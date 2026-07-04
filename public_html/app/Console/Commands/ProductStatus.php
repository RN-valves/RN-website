<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\{ Order, OrderLog, OrderTransport };
use Illuminate\Support\Facades\Log;

class ProductStatus extends Command
{
    protected $signature = 'app:product-status';
    protected $description = 'Product status update through Shipway API';

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
                ->with('user:id,name')
                ->get();

            if ($orders->isEmpty()) {
                return;
            }

            $token = shipwayKey();
            $client = new Client();
            $headers = [
                'Authorization' => 'Basic ' . $token,
                'Content-Type'  => 'application/json'
            ];

            $updates = [];

            foreach ($orders as $order) {
                if(isset($order->orderTransort)){      
                    try {
                        $response = $client->get('https://app.shipway.com/api/getorders', [
                            'headers' => $headers,
                            'query'   => ['orderid' => 'RNOD' . $order->id]
                        ]);
    
                        $data = json_decode($response->getBody(), true);
    
                        if (empty($data['message']) || !isset($data['message'][0]['shipment_status_name'])) {
                            Log::warning("Invalid or empty response for order RNOD{$order->id}");
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
                        Log::error("Error fetching order RNOD{$order->id}: " . $e->getMessage());
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
                    // if($update['status'] == 'In Transit'){
                    //     $templateId = '6801d99dd6fc053724610852';
                    //     $params = [
                    //         'name' => (string)$order->user->name,
                    //         'orderid' => 'RNOD'.$order->id,
                    //         'trackid' => $update['tracking_id'],
                    //         'trackurl' => 'https://rnvalves.shipway.com/track',
                    //     ];
                    //     SendSMS($templateId,$params);

                    // }
                    // if($update['status'] == 'Delivered'){
                    //     $templateId = '6801da1fd6fc05091b1dca33';
                    //     $params = [
                    //         'name' => (string)$order->user->name,
                    //         'orderid' => 'RNOD'.$order->id,
                    //         'feedbackurl' => 'www.rnvalves.com',
                    //         'tollfree' => '1800123400400',
                    //     ];
                    //     SendSMS($templateId,$params);

                    // }
                }

                //Log::info("Successfully updated " . count($updates) . " orders.");
            }
        } catch (\Exception $e) {
            Log::error("Shipway API Order Sync Error: " . $e->getMessage());
        }
    }
}
