{{-- @component('mail::message')
Hello! <b class="text-dark">{{ $order->name??'' }}</b>
<h1>Order Invoice - #OD{{ $order->id }}</h1>
<p>Dear {{ $order->name??'' }},</p>
<p>Thank you for your order. Below are the details of your purchase.</p>
<!-- Order Summary -->
<table>
   <tr>
      <th>Order ID-</th>
      <td>#OD{{ $order->id }}</td>
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
@endcomponent --}}



@component('mail::message')
Hello! <b class="text-dark">{{ $order->name??'' }}</b>
<h1>Order Invoice - #OD{{ $order->id }}</h1>
<p>Dear {{ $order->name??'' }},</p>
<p>Thank you for your order. Below are the details of your purchase.</p>

<!-- Order Summary -->
<h2>Order Summary</h2>
<table style="width: 100%; border-collapse: collapse;">
   <tr>
      <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Order ID-</th>
      <td style="padding: 8px; border: 1px solid #ddd;">#OD{{ $order->id }}</td>
   </tr>
   <tr>
      <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Order Date</th>
      <td style="padding: 8px; border: 1px solid #ddd;">{{ $order->created_at->format('d M Y') }}</td>
   </tr>
   <tr>
      <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Customer Name</th>
      <td style="padding: 8px; border: 1px solid #ddd;">{{ $order->name??'' }}</td>
   </tr>
   <tr>
      <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Customer Email</th>
      <td style="padding: 8px; border: 1px solid #ddd;">{{ $order->email??'' }}</td>
   </tr>
   <tr>
      <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Payment Method</th>
      <td style="padding: 8px; border: 1px solid #ddd;">{{ $order->payment_term == 'Prepaid' ? 'Online Payment' : 'Cash on Delivery' }}</td>
   </tr>
</table>

<!-- Order Items -->
<h2>Order Items</h2>
<table style="width: 100%; border-collapse: collapse;">
   <thead>
      <tr>
         <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Product</th>
         <th style="text-align: right; padding: 8px; border: 1px solid #ddd;">Price</th>
         <th style="text-align: center; padding: 8px; border: 1px solid #ddd;">QTY</th>
         <th style="text-align: right; padding: 8px; border: 1px solid #ddd;">Total</th>
      </tr>
   </thead>
   <tbody>
      @foreach($order->order_items ?? [] as $item)
      <tr>
         <td style="padding: 8px; border: 1px solid #ddd;">
            {{ $item->product->name ?? 'Product' }}<br>
            @if($item->product_size)
               Size: {{ $item->product_size }}<br>
            @endif
            @if($item->product_color)
               Color: {{ $item->product_color }}
            @endif
         </td>
         <td style="text-align: right; padding: 8px; border: 1px solid #ddd;">₹{{ number_format($item->price ?? 0, 2) }}</td>
         <td style="text-align: center; padding: 8px; border: 1px solid #ddd;">{{ $item->total_qty ?? 0 }}</td>
         <td style="text-align: right; padding: 8px; border: 1px solid #ddd;">₹{{ number_format($item->total_amount ?? 0, 2) }}</td>
      </tr>
      @endforeach
   </tbody>
</table>

<!-- Order Totals -->
<h2>Order Totals</h2>
<table style="width: 100%; border-collapse: collapse;">
   <tr>
      <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">SubTotal</th>
      <td style="text-align: right; padding: 8px; border: 1px solid #ddd;">₹{{ number_format($order->order_items->sum('total_amount'), 2) }}</td>
   </tr>
   @if($order->discount_amount > 0)
   <tr>
      <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Discount</th>
      <td style="text-align: right; padding: 8px; border: 1px solid #ddd; color: green;">- ₹{{ number_format($order->discount_amount ?? 0, 2) }}</td>
   </tr>
   @endif
   @if($order->shipping_amount > 0)
   <tr>
      <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Shipping Charge</th>
      <td style="text-align: right; padding: 8px; border: 1px solid #ddd;">₹{{ number_format($order->shipping_amount ?? 0, 2) }}</td>
   </tr>
   @endif
   @if($order->payment_term == 'COD' && $order->total_amount > $order->order_items->sum('total_amount') - $order->discount_amount + $order->shipping_amount)
   <tr>
      <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">COD Charge</th>
      <td style="text-align: right; padding: 8px; border: 1px solid #ddd;">₹{{ number_format(90, 2) }}</td>
   </tr>
   @endif
   <tr>
      <th style="text-align: left; padding: 8px; border: 1px solid #ddd; background-color: #f8f9fa;">Total Amount</th>
      <th style="text-align: right; padding: 8px; border: 1px solid #ddd; background-color: #f8f9fa;">₹{{ number_format($order->total_amount ?? 0, 2) }}</th>
   </tr>
</table>

<p>If you have any questions about your order, please contact our customer support.</p>

<p>Regards,</p>
<p><b>{{ config('app.name') }}</b></p>

<style>
   /* Add some basic styling to make the invoice look decent */
   body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
   }
   h1 {
      color: #333;
      border-bottom: 2px solid #333;
      padding-bottom: 10px;
   }
   h2 {
      color: #555;
      margin-top: 20px;
      margin-bottom: 10px;
   }
   table {
      margin-bottom: 20px;
   }
   th {
      background-color: #f8f9fa;
      font-weight: bold;
   }
</style>
@endcomponent