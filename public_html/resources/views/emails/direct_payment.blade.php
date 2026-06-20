@component('mail::message')
   <div class="container">
      <div class="header">
         <h1>Payment Confirmation</h1>
      </div>
      <div class="content">
         <p>Dear {{ $payment->name??'' }},</p>
         <p>We are pleased to confirm that your payment of {{ $payment->amount??0 }} has been successfully processed.</p>
         <p>Your order details are as follows:</p>
         <ul>
            <li>Payment Date: {{ $payment->created_at->format('d M Y, H:i:s') }}</li>
            <li>Payment Status: {{ $payment->status??'' }}</li>
            <li>Payment Id: {{ $payment->payment_id??'' }}</li>
         </ul>
         <p>If you have any questions or concerns, please don't hesitate to contact us.</p>
         <p>Thank you for your business.</p>
      </div>
   </div>
<p>Best Regards,</p>
<p>{{ config('app.name') }}</p>
<style>
      .container {
         max-width: 600px;
         margin: 40px auto;
         padding: 20px;
         background-color: #fff;
         border: 1px solid #ddd;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }
      .header {
         background-color: #333;
         color: #fff;
         padding: 10px;
         text-align: center;
      }
      .header h1 {
         margin: 0;
      }
      .content {
         padding: 20px;
      }
      .content p {
         margin-bottom: 20px;
      }
      .button {
         background-color: #4CAF50;
         color: #fff;
         padding: 10px 20px;
         border: none;
         border-radius: 5px;
         cursor: pointer;
      }
      .button:hover {
         background-color: #3e8e41;
      }
</style>
@endcomponent