<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Proforma</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }
    </style>
</head>
<body>
@php
@endphp

    <div class="invoice-container">
        <!-- Header Section -->
        <header>
            <div class="company-info">
                <h4>RN FAUCETS PRIVATE LIMITED</h4>
                <p>Address: B-68 Site-4 Industrial Area, Sahibabad Ghaziabad-201010</p>
                <p>Phone: 1800123400400</p>
                <p>Email: enquiry@rnvalves.com</p>
                <p>website: <a href="https://rnvalves.com/">www.rnvalves.com</a></p>
                <p><strong>GSTIN No.: 09AAKCR3772K1ZR</strong></p>
            </div>
            <div class="invoice-info">
                <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('users/images/logoc.png')))}}" width="100px">
                <h2 class="mb-1">RNOD #{{$order->id}}</h2>
                <p>Date: {{ $order->updated_at->format('d M Y') }}</p>
            </div>
        </header>
        
        <!-- Bill To Section -->
        <section class="customer-info">
            <h2>Bill To:</h2>
            <p>{{ $order->name }}</p>
            <p>{{ $order->booking_address }}</p>
            <p>Phone: {{ $order->mobile }}</p>
            <p>Email: {{ $order->email }}</p>
        </section>
        
        <!-- Order Details Section -->
        <section class="order-details">
            <h2>Order Details:</h2>
            <table>
                <thead>
                    <tr>
                        <th style="text-align: left!important;">Product Description</th>
                        <th>Code</th>
                        <th>HSN</th>
                        <th>QTY</th>
                        <th>Unit Price</th>
                        <th style="width: 50px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->order_items??'' as $item)
                    <tr>
                        <td style="text-align: left!important;">{{ $item->product->name }} - {{ $item->product_size }} ({{ $item->product_color }})</td>
                        <td>{{ $item->product_code??'' }}</td>
                        <td>{{ $item->product->hsn ?? '—' }}</td>
                        <td>{{ $item->total_qty }}</td>
                        <td>{{ $item->price }}</td>
                        <td style="width: 50px;">{{ $item->total_amount }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    @if($order->payment_term == 'COD')
                    <tr>
                        <th colspan="4"  style="text-align: right!important;">COD Charge:</th>
                        <td>90</td>
                    </tr>
                    @endif
                    <tr>
                        <th colspan="5"  style="text-align: right!important;">Subtotal:</th>
                        <td>{{ ($order->total_amount+$order->discount_amount) - $order->shipping_amount }}</td>
                    </tr>
                    @if(!empty($order->discount_amount) || $order->discount_amount>0)
                    <tr>
                        <th colspan="5" style="text-align: right!important;">Discount:</th>
                        <td style="color:green;"> - {{ $order->discount_amount }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th colspan="5" style="text-align: right!important;">Shipping Charges:</th>
                        <td>{{ $order->shipping_amount }}</td>
                    </tr>
                    <tr>
                        <th colspan="5" style="text-align: right!important;">Total:</th>
                        <td>{{ $order->total_amount }}</td>
                    </tr>
                </tfoot>
            </table>
        </section>
        
        <!-- Payment Information Section -->
        <section class="payment-info">
            <h2>Payment Terms:</h2>
            <p>Payment Method: <strong>{{ $order->payment_term }}</strong></p>
        </section>
    </div>
</body>
</html>

<style type="text/css">
body{
    font-size: 12px;
}
.invoice-container {
    margin: 3mm;
    padding: 3mm;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.company-info {
    float: left;
    width: 40%;
}

.invoice-info {
    float: right;
    width: 40%;
    text-align: right;
}

.customer-info {
    clear: both;
    margin-top: 20px;
}

.order-details {
    margin-top: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
}

th {
    background-color: #f0f0f0;
}

tfoot th {
    background-color: #f0f0f0;
    font-weight: bold;
}

tfoot td {
    font-weight: bold;
}

.payment-info {
    margin-top: 20px;
}

/* Print styles */
@media print {
    .invoice-container {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        border: 1px solid dark;
    }
}
</style>