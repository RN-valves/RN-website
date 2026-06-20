@component('mail::message')
Hello! <b class="text-dark">{{ $order->name??'' }}</b>
<h1>Order Invoice - #OD{{ $order->id }}</h1>
<p>Dear {{ $order->name??'' }},</p>
<p>Thank you for your order. Below are the details of your purchase.</p>
<p><strong>Order Status : </strong>{{ $order->status??'' }}</p>
<!-- Order Summary -->
<table>
   <tr>
      <th>Order ID</th>
      <td>#OD{{ $order->id }}</td>
   </tr>
   <tr>
      <th>Order Status</th>
      <td>{{ $order->status??'' }}</td>
   </tr>
   <tr>
      <th>Order Date</th>
      <td>{{ $order->created_at->format('d M Y') }}</td>
   </tr>
   <tr>
      <th>Customer Name</th>
      <td>{{ $order->name??'' }}</td>
   </tr>
   <tr>
      <th>Customer Email</th>
      <td>{{ $order->email??'' }}</td>
   </tr>
</table>
<!-- Order Items -->
<h2>Order Items</h2>
<table>
   <tr>
      <th>Product</th>
      <th>Price</th>
      <th>QTY</th>
      <th>Total</th>
   </tr>
   @foreach($order->order_items??'' as $item)
   <tr>
      <td>{{ substr($item->product->name??'',0,33) }}..<br> Size : {{ $item->product_size??'' }} <br> Color : {{ $item->product_color??'' }}</td>
      <td>{{ $item->price??0 }}</td>
      <td>{{ $item->total_qty??0 }}</td>
      <td>{{ $item->total_amount??0 }}</td>
   </tr>
   @endforeach
</table>
<!-- Order Totals -->
<h2>Order Totals</h2>
<table>
   <tr>
      <th>SubTotal</th>
      <td>{{ $order->order_items->sum('total_amount') }}</td>
   </tr>
   <tr>
      <th>Discount</th>
      <td>{{ $order->discount_amount??0 }}</td>
   </tr>
   <tr>
      <th>Shipping Charge</th>
      <td>{{ $order->shipping_amount??0 }}</td>
   </tr>
   <tr>
      <th>Total Amount</th>
      <th>{{ $order->total_amount??0 }}</th>
   </tr>
</table>
<p>Regards,</p>
<p>{{ config('app.name') }}</p>
<style>
   /* Add some basic styling to make the invoice look decent */
   body {
   font-family: Arial, sans-serif;
   }
   table {
   border-collapse: collapse;
   width: 100%;
   }
   th, td {
   border: 1px solid #ddd;
   padding: 8px;
   text-align: left;
   }
</style>
@endcomponent