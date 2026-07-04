<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

use App\Models\UserAddress;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function getSingleOrder($id){
        return self::find($id);
    }

    public static function getSingleOrderUuid($uuid){
        return self::where('uuid', $uuid)->first();
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order_items(){
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function getRouteKeyName(){
        return "uuid";
    }

    public function orderLogs(){
        return $this->hasMany(OrderLog::class, 'order_id');
    }

    public function order_cancel_log(){
        return $this->hasOne(OrderCancelLog::class, 'order_id');
    }

    public function orderTransort(){
        return $this->hasOne(OrderTransport::class, 'order_id');
    }

    public static function orderStatuses(){
        return array('Pending','In-Progress','In-Transit','Delivered','Completed','Cancelled');
    }

    public static function fulfillmentTypes(){
        return ['Delivery', 'Store Pickup', 'Manual Delivery'];
    }

    public function isPaid(): bool
    {
        return in_array($this->is_payment, [1, '1', 'Complete', 'Yes'], true);
    }

    public function isStorePickup(): bool
    {
        return $this->fulfillment_type === 'Store Pickup';
    }

    public function isManualDelivery(): bool
    {
        return $this->fulfillment_type === 'Manual Delivery';
    }

    public function skipsShipway(): bool
    {
        return $this->isStorePickup() || $this->isManualDelivery();
    }

    public function hasShipwayData(): bool
    {
        return ($this->delivery_charge > 0)
            || !empty($this->orderTransort)
            || ($this->package_length > 0);
    }

    public function requiresTransportForStatus(string $status): bool
    {
        if ($this->isStorePickup()) {
            return in_array($status, ['In-Transit', 'Delivered'], true);
        }

        if ($this->isManualDelivery()) {
            return false;
        }

        if (in_array($status, ['In-Transit', 'Delivered', 'Completed'], true)) {
            return !$this->hasShipwayData();
        }

        return false;
    }

    public static function getOrderWeekly(){
        return Order::query()
            ->whereNotIn('status', ['Pending','Cancelled'])
            ->whereYear('created_at', date('Y'))
            ->get()
            ->groupBy(fn($item) => $item->created_at->format('W M'));
    }

    public static function getOrderMonthly(){
        return Order::query()
            ->whereNotIn('status', ['Pending','Cancelled'])
            ->whereYear('created_at', date('Y'))
            ->get()
            ->groupBy(fn($item) => $item->created_at->format('M Y'));
    }

    public static function total_verified_sale_cr_month(){
        return self::whereNotIn('status', ['Pending','Cancelled'])
            ->whereMonth('created_at', now())
            ->whereYear('created_at',now())
            ->get();
    }

    public static function total_verified_sale_today(){
        return self::whereNotIn('status', ['Pending','Cancelled'])
            ->whereDate('created_at', now())
            ->get();
    }

    /*public static function ship_rocket_detail($order_id){
        $order = self::where('id', $order_id)->first();
        
        $order['order_id'] = $order_id;
        $order['order_date'] = $order->created_at;
        $order['channel_id'] = "";
        $order['comment'] = $order['note']??'';
        $order['billing_customer_name'] = $order->name;
        $order['billing_last_name'] = $order->name;
        $order['billing_address'] = $order->user->address;
        $order['billing_address_2'] = "";
        $order['billing_city'] = $order->city;
        $order['billing_pincode'] = $order->zipcode;
        $order['billing_state'] = $order->state;
        $order['billing_country'] = $order->country;
        $order['billing_email'] = $order->email;
        $order['billing_phone'] = $order->mobile;
        $order['shipping_is_billing'] = true;

        $getShippingAddress = UserAddress::whereId($order->shipping_charge_id)->first();
        if(!empty($getShippingAddress)){
            $order['shipping_customer_name'] = $getShippingAddress->name;
            $order['shipping_last_name'] = $getShippingAddress->name;
            $order['shipping_address'] = $order->booking_address;
            $order['shipping_address_2'] = "";
            $order['shipping_city'] = $getShippingAddress->city->name;
            $order['shipping_pincode'] = $getShippingAddress->zipcode;
            $order['shipping_state'] = $getShippingAddress->state->name;
            $order['shipping_country'] = $getShippingAddress->country->name;
            $order['shipping_email'] = $order->email;
            $order['shipping_phone'] = $getShippingAddress->mobile;
        }

        foreach ($order['order_items'] as $key => $item) {
            $order['order_items'][$key]['name'] = $item->product->name;
            $order['order_items'][$key]['sku'] = $item->product_code;
            $order['order_items'][$key]['units'] = $item->total_qty;
            $order['order_items'][$key]['selling_price'] = $item->price;
            $order['order_items'][$key]['discount'] = "";
            $order['order_items'][$key]['tax'] = "";
            $order['order_items'][$key]['hsn'] = $item->product->hsn;
        }

        $order['payment_method'] = $order->payment_term;
        $order['shipping_charges'] = $order->shipping_amount;
        $order['giftwrap_charges'] = 0;
        $order['transaction_charges'] = 0;
        $order['total_discount'] = $order->discount_amount;
        $order['sub_total'] = $order->total_amount;
        $order['length'] = $order->package_length??10;
        $order['breadth'] = $order->package_breadth??10;
        $order['height'] = $order->package_height??10;
        $order['weight'] = $order->package_weight??1;

        return Http::withToken(env('SHIPROCKET_TOKEN'))->post('https://apiv2.shiprocket.in/v1/external/orders/create/adhoc',$order);
    }*/

    public function payment(){
        return $this->hasOne(Payment::class, 'order_id');
    }
}
