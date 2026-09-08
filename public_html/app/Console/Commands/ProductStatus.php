<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\{ Order, OrderLog, OrderTransport };
use Illuminate\Support\Facades\Log;

class ProductStatus extends Command
{
    protected $signature = 'app:product-status';
    protected $description = 'Product status update through Shipway and Shiprocket APIs';

    public function handle()
    {
        try {
            $orders = Order::where('delivery_charge','>',0)
                ->where(function ($query) {
                    $query->where('fulfillment_type', 'Delivery')
                        ->orWhereNull('fulfillment_type');
                })
                ->whereNotIn('status', ['Delivered', 'RTO Delivered', 'Canceled', 'Return Delivered', 'Completed'])
                ->select('id', 'user_id', 'status')
                ->with(['user:id,name', 'orderTransort'])
                ->get();

            if ($orders->isEmpty()) {
                return;
            }

            $shipwayToken = shipwayKey();
            $shiprocketToken = shiprocketToken();
            $client = new Client();

            $updates = [];

            foreach ($orders as $order) {
                if(!isset($order->orderTransort) || empty($order->orderTransort->order_tracking_id)) {
                    continue;
                }

                $isShiprocket = str_contains(strtolower($order->orderTransort->transport_name ?? ''), 'shiprocket') ||
                                str_contains(strtolower($order->orderTransort->transport_url ?? ''), 'shiprocket');

                if ($isShiprocket && $shiprocketToken) {
                    try {
                        $awb = $order->orderTransort->order_tracking_id;
                        $srRes = $client->get('https://apiv2.shiprocket.in/v1/external/courier/track/awb/' . $awb, [
                            'headers' => [
                                'Authorization' => 'Bearer ' . $shiprocketToken,
                                'Content-Type'  => 'application/json'
                            ]
                        ]);
                        $srData = json_decode($srRes->getBody()->getContents(), true);
                        if (!empty($srData['tracking_data']['shipment_track'][0]['current_status'])) {
                            $rawStatus = $srData['tracking_data']['shipment_track'][0]['current_status'];
                            $mappedStatus = $this->mapShiprocketStatus($rawStatus);
                            if ($mappedStatus) {
                                $updates[] = [
                                    'order'          => $order,
                                    'status'         => $mappedStatus,
                                    'tracking_id'    => $awb,
                                    'transport_name' => $order->orderTransort->transport_name ?? 'Shiprocket'
                                ];
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error("Error fetching Shiprocket tracking for RNOD{$order->id}: " . $e->getMessage());
                    }
                } else {
                    try {
                        $response = $client->get('https://app.shipway.com/api/getorders', [
                            'headers' => [
                                'Authorization' => 'Basic ' . $shipwayToken,
                                'Content-Type'  => 'application/json'
                            ],
                            'query'   => ['orderid' => 'RNOD' . $order->id]
                        ]);
    
                        $data = json_decode($response->getBody(), true);
    
                        if (empty($data['message']) || !isset($data['message'][0]['shipment_status_name'])) {
                            continue;
                        }
    
                        $shipment = $data['message'][0];
    
                        $updates[] = [
                            'order'         => $order,
                            'status'        => $shipment['shipment_status_name'] ?? '',
                            'tracking_id'   => $shipment['tracking_number'] ?? '',
                            'transport_name'=> $shipment['name'] ?? ''
                        ];
                    } catch (\Exception $e) {
                        Log::error("Error fetching Shipway tracking for RNOD{$order->id}: " . $e->getMessage());
                    }
                }
            }

            if (!empty($updates)) {
                foreach ($updates as $update) {
                    $order = $update['order'];

                    if ($order->status === $update['status']) {
                        continue;
                    }
                    if ($update['status'] == 'Pickup Failed' || $update['status'] == 'Pickup Cancelled') {
                        continue;
                    }

                    $order->update(['status' => $update['status']]);

                    OrderLog::create([
                        'order_id'     => $order->id,
                        'user_id'      => $order->user_id,
                        'user_name'    => $order->user->name ?? 'System',
                        'change_value' => $update['status'],
                        'change_type'  => "status",
                    ]);   
                }
            }
        } catch (\Exception $e) {
            Log::error("Shipping API Order Sync Error: " . $e->getMessage());
        }
    }

    private function mapShiprocketStatus($status)
    {
        $s = strtoupper(trim($status));
        if (str_contains($s, 'DELIVERED') && !str_contains($s, 'RTO')) {
            return 'Delivered';
        } elseif (str_contains($s, 'TRANSIT') || str_contains($s, 'SHIPPED') || str_contains($s, 'PICKED')) {
            return 'In-Transit';
        } elseif (str_contains($s, 'RTO DELIVERED')) {
            return 'RTO Delivered';
        } elseif (str_contains($s, 'CANCELED') || str_contains($s, 'CANCELLED')) {
            return 'Cancelled';
        }
        return null;
    }
}
