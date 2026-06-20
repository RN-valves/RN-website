<?php
namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Collection;

class OrderReportExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        $rows = [];

        foreach ($this->orders as $order) {
            foreach ($order->order_items as $item) {
                $rows[] = (object)[
                    'id' => 'RNOD' . $order->id,
                    'created_at' => $order->created_at->format('d-m-Y h:i A'),
                    'name' => $order->name,
                    'mobile' => $order->mobile,
                    'state' => $order->state,
                    'city' => $order->city,
                    'zipcode' => $order->zipcode,
                    'order_amount' => number_format($order->total_amount, 2),
                    'is_payment' => $order->is_payment ? 'Yes' : 'No',
                    'discount_code' => $order->discount_code ?? '',
                    'discount_amount' => number_format($order->discount_amount, 2),
                    'status' => $order->status,
                    'payment_term' => $order->payment_term ?? '',
                    'transport_name' => $order->orderTransort->transport_name ?? '',
                    'order_tracking_id' => $order->orderTransort->order_tracking_id ?? '',
                    'attachment' => $order->orderTransort->attachment ?? '',
                    'product_name' => $item->product->name ?? '',
                    'sku_code' => $item->product->sku_code ?? '',
                    'quantity' => $item->total_qty ?? 0,
                    'product_price' => number_format($item->price ?? 0, 2),
                    'total_amount' => number_format($item->total_amount ?? 0, 2)
                ];
            }
        }

        return new Collection($rows);
    }

    public function headings(): array
    {
        return [
            'Invoice No',
            'Created Date',
            'Name',
            'Mobile',
            'State',
            'City',
            'Pincode',
            'Order Amount',
            'Is Payment',
            'Discount Code',
            'Discount',
            'Status',
            'Payment Term',
            'Courier Name',
            'Tracking Number',
            'Shipping Label',
            'Product Name',
            'SKU Code',
            'Quantity',
            'Product Price',
            'Total Amount'
        ];
    }

    // public function map($row): array
    // {
    //     return [
    //         $row->id,
    //         $row->created_at,
    //         $row->name,
    //         $row->mobile,
    //         $row->state,
    //         $row->city,
    //         $row->zipcode,
    //         $row->total_amount,
    //         $row->is_payment,
    //         $row->discount_code,
    //         $row->discount_amount,
    //         $row->status,
    //         $row->payment_term,
    //         $row->orderTransort->transport_name,
    //         $row->orderTransort->order_tracking_id,
    //         $row->orderTransort->attachment,
    //         $row->product->name,
    //         $row->product->sku_code,
    //         $row->total_qty,
    //         $row->price,
    //         $row->total_amount,
    //     ];
    // }
}
