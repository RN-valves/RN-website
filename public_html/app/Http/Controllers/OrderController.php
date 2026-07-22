<?php

namespace App\Http\Controllers;

use App\Models\{
    OrderTransport,
    Order,
    OrderLog,
    Product,
    Category,
    Subcategory,
    UserAddress,
    OrderItem,
    Payment
};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Mail\OrderStatusMail;
use Mail;
use PDF;
use Dompdf\Options;
use Cart;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:order-list'], ['only' => ['index']]);
        $this->middleware(['permission:order-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:order-edit'], ['only' => ['edit', 'update', 'markPaymentReceived', 'setStorePickup', 'completeStorePickup', 'completeWithoutShipway', 'updateOrderStatus']]);
        $this->middleware(['permission:order-delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $orders = Order::all();
            return view('admin.orders.index', compact('orders'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        try{
            return view('admin.orders.show', compact('order'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order, Request $request)
    {
        $user = $order->user;
        if(!empty(request('url_key') || !empty(request('q')))){
            $getSingleSubCategory = Subcategory::getSingleSubCategory(request('url_key'));
            if(!empty($getSingleSubCategory))
            {
                $productsList = Product::getProducts($getSingleSubCategory->id);
                    return view('admin.customers.orders.edit', compact('getSingleSubCategory','productsList','user','order'));
            }
            elseif(!empty(request('q'))){
                $productsList = Product::getProducts();
                return view('admin.customers.orders.edit', compact('productsList', 'user','order'));
            }
            else
            {
                abort(404);
            }
        }
        Cart::destroy();
        foreach ($order->order_items as $key => $item) {
            Cart::add([
                'id' => $item->id, 
                'name' => $item->product->name, 
                'qty' => $item->total_qty, 
                'price' => $item->price, 
                'weight' => $item->product_lbh_weight_gm??0, 
                'options' => [
                    'size' => $item->product_size,
                    'color' => $item->product_color,
                    'product_code' => $item->product_code,
                ]
            ]);
        }
        return view('admin.customers.orders.edit', compact('user','order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', Rule::in(['Pending','In-Progress','In-Transit','Delivered','Completed','Cancelled'])],
            'order_id' => ['required','exists:orders,id'],
        ]);
        try{
            $data= $request->all();

            if($data['status']=="Delivered" || $data['status']=="In-Transit" || $data['status']=="Completed"){
                $order_transport = OrderTransport::checkOrderTransport($order->id);

                if(!empty($order_transport) || !$order->requiresTransportForStatus($data['status'])){
                    $order->status = $data['status'];
                    $order->save();

                    OrderLog::create(
                        [
                            'order_id' => $order->id,
                            'user_id' => auth()->user()->id,
                            'user_name' => auth()->user()->name,
                            'change_value' => $data['status'],
                            'change_type' => "status",
                        ],
                    );
                }else{
                    return back()->with('error', 'First need to update transport details for this order');
                }

            }
            else
            {
                $order->status = $data['status'];
                $order->save();

                OrderLog::create(
                    [
                        'order_id' => $order->id,
                        'user_id' => auth()->user()->id,
                        'user_name' => auth()->user()->name,
                        'change_value' => $data['status'],
                        'change_type' => "status",
                    ],
                );
            }

            Mail::to($order->email)->send(new OrderStatusMail($order));
            return back()->with('success', 'order status had been updated successfully!!');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        //
    }

    public function generate_order_pdf(Request $request, Order $order){

        $getOrder = Order::getSingleOrder($order->id);
        if(!empty($getOrder)){

            $data = [
                'title' => 'RN Ecommerce Order',
                'date' => now(),
                'order' => $getOrder
            ];

            $options = new Options();
            $options->set('defaultFont', 'Verdana');

            //Pdf::setOption(['dpi' => 150, 'defaultFont' => 'Verdana, sans-serif']);

            $pdf = PDF::loadView('pdfs.order_pdf', $data);

            // /return $pdf->download();
            // return $pdf->stream(); 

            // Generate filename with order ID
              $filename = 'RNOD' . $order->id . '.pdf';
   
            // Download with custom filename instead of stream
               return $pdf->download($filename);

        }
        else
        {
            abort(404);
        }

    }

    public function AdminorderUpdate(Order $order, Request $request){
        if($request->isMethod("post")){
            $request->validate([
                'shipping_charge_id' => ['required', 'exists:user_addresses,id'],
                'note' => ['nullable','max:255','string'],
                'payment_term' => ['required',Rule::in(['100% Advanced', 'Credit'])],
                'discount_amount' => ['nullable','numeric'],
                'shipping_amount' => ['required','numeric'],
            ]);
            $data = $request->only('shipping_charge_id', 'note', 'payment_term','discount_amount','shipping_amount');
            $order = Order::whereId($order->id)->first();
            $userAddress = UserAddress::whereId($data['shipping_charge_id'])->first();
            if(!empty($user)){
                $order->user_id = trim($user->id);
                $order->shipping_charge_id = $data['shipping_charge_id'];
                $order->name = $user->name;
                $order->mobile = $user->mobile;
                $order->email = $user->email ?? 'noreply@rnvalves.com';
                $order->country = $user->country->name??'';
                $order->state = $user->state->name??'';
                $order->city = $user->city->name??'';
                $order->zipcode = $user->zipcode??'';

                if(!empty($user->pincode_id)){
                    $order->pincode_id = $user->pincode_id??0;
                }
            }

            $order->uuid = str()->uuid()->toString();
            $order->booking_address =  $userAddress->address. ' ' .$userAddress->state->name. '-' .$userAddress->zipcode;
            $order->note =  $data['note']??null;

            $subtotal = Cart::subtotal(2, '.', '');
            $shipping_amount = number_format($data['shipping_amount'],2, '.', '');
            $total_amount = round($shipping_amount+$subtotal,2);

            if(!empty($data['discount_amount'])){
                $discount_amount = number_format($data['discount_amount'],2, '.', '');
                $order->discount_code =  "Admin";
                $order->discount_amount =  $discount_amount;
                $total_amount = round($total_amount-$discount_amount,2);
            }

            $order->shipping_amount =  $shipping_amount??0;
            $order->total_amount =  $total_amount??0;
            $order->payment_term =  $data['payment_term']??null;
            $order->save();

            OrderItem::where('order_id', $order->id)->delete();

            foreach(Cart::content() as $key => $item){
                $pro = Product::where('sku_code',$item->options->product_code)->first();
                OrderItem::updateOrCreate( 
                    [
                        'order_id' => $order->id,
                        'cart_id' => $item->rowId,
                    ],
                    [
                        'order_id' => $order->id,
                        'product_id' => $pro->id,
                        'product_code' => $item->options->product_code,
                        'cart_id' => $item->rowId,
                        'product_color' => $item->options->color,
                        'product_size' => $item->options->size,
                        'price' => $item->price,
                        'product_lbh_weight_gm' => $item->weight??0,
                        'total_qty' => $item->qty,
                        'total_amount' => round($item->price*$item->qty,2),
                    ]
                );

            }

            OrderLog::create(
                [
                    'order_id' => $order->id,
                    'user_id' => auth()->user()->id,
                    'user_name' => auth()->user()->name,
                    'change_value' => "Pending",
                    'change_type' => "order_edit",
                ],
            );
            Cart::destroy();
            return redirect(route('orders.show', $order))->with('success', 'order created successfully!!');
        }
    }

    public function generatePaymentLink(Order $order, Request $request){
        $client = new Client();
        try{
            razorpay_post_order($order->id);
            $result = razorpay_payment_link_create($order->id);

            $order->pay_link_id = $result->id;
            $order->save();

            /*store payment transaction detail in our database */
            Payment::updateOrCreate(
                [
                    'payment_id' => $result->reference_id,
                ],
                [
                    'payment_id' => $result->reference_id,
                    'pay_link_id' => $result->id,
                    'short_url' => $result->short_url,
                    'order_id' => $order->id,
                    'name' => $order['name'],
                    'mobile' => $order['mobile'],
                    'email' => $order['email'],
                    'state' => $order['state'],
                    'city' => $order['city'],
                    'zipcode' => $order['zipcode'],
                    'payment_gateway' => "Razorypay",
                    'payment_key' => env('RAZORPAY_KEY'),
                    'payment_secret_key' => env('RAZORPAY_SECRET'),
                    'status' => "Created",
                    'payment_data' => "",
                    'amount' => $order->total_amount,
                ],
            );

            //return view('users.websites.payments.razorpay_success', compact('result','order'));
            //header('Location: '.$result->short_url);
            exit();
            return back()->with('success', 'payment link generated successfully!!');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function getCarrierRate(Request $request)
    {

       $order = Order::find($request->order_id);
       if (!$order) {
           return response()->json(['error' => 'Order not found'], 404);
       }
       
       $paymentMode = ($order->payment_term == 'Prepaid') ? "prepaid" : "cod";
        if ($paymentMode === 'cod') {
           $codAmount = (int) $order->total_amount;
        }else{
           $codAmount = 0;
        }
       $token = shipwayKey();
       
       $client = new Client();
       $queryParams = http_build_query([
           "fromPincode"      => 201010,
           "toPincode"        => (int) $order->zipcode,
           "paymentType"      => $paymentMode,
           "length"          => (int) $request->length,
           "breadth"         => (int) $request->breadth,
           "height"          => (int) $request->height,
           "weight"          => (int) $request->weight,
           "cummulativePrice" => (int) $codAmount,
       ]);
       
       $url = 'https://app.shipway.com/api/getshipwaycarrierrates?' . $queryParams;
       
       try {
           $request1 = new \GuzzleHttp\Psr7\Request('GET', $url, [
               'Authorization' => 'Basic ' . $token,
               'Content-Type'  => 'application/json'
           ]);
           
           $response = $client->sendAsync($request1)->wait();
           $data = json_decode($response->getBody()->getContents(), true);
           if (!isset($data['rate_card']) || empty($data['rate_card'])) {
               return response()->json(['error' => 'No carrier rates found'], 404);
           }
           $options = "<option value=''>Select Courier</option>";
           foreach ($data['rate_card'] as $rate) {
                $gstCharge = $rate['delivery_charge']*18/100;
                $totalDeliveryCharge = $gstCharge+$rate['delivery_charge'];
                $codCharge = isset($rate['cod_charges']) ? $rate['cod_charges'] : 0;
                $options .= "<option value='{$rate['carrier_id']}' data-courier-name='{$rate['courier_name']}' data-delivery-charge='{$rate['delivery_charge']}' data-cod-charge='{$codCharge}' >";
                $options .= "{$rate['courier_name']} - ₹ {$totalDeliveryCharge}";
               if ($paymentMode === 'cod') {
                   $options .= " (COD Charge: ₹ {$codCharge})";
               }
               $options .= "</option>";
           }
           return response()->json([
               'success' => true,
               'all' => $data['rate_card'],
               'html' => $options,
               'message' => 'Data fetched successfully'
           ]);
       } catch (RequestException $e) {
           return response()->json([
               'success' => false,
               'error'   => 'Failed to fetch carrier rates',
               'message' => $e->getMessage()
           ], $e->getCode() ?: 500);
       }
        
    }

    public function AssignCarrier(Request $request){
        // try{
            $request->validate([
                'box_length' => ['required'],
                'box_breadth' => ['required'],
                'box_height' => ['required'],
                'carrier_id' => ['required','numeric'],
                'order_id' => ['required','numeric'],
                'courier_name' => ['required'],
                'delivery_charge' => ['required'],
                'cod_charge' => ['required'],
            ]);
            $gstcharge = ($request->cod_charge+$request->delivery_charge)*18/100;
            $order = Order::find($request->order_id);

            if ($order->isStorePickup()) {
                return back()->with('error', 'Store Pickup orders cannot be processed through Shipway.');
            }

            if ($order->isManualDelivery()) {
                return back()->with('error', 'This order was completed without Shipway.');
            }
            
            $reponse = order_push_shipway($order,$request);
            //Log::info("Data fetching order RNOD{$order->id}: " . $reponse);
            if(isset($reponse) && $reponse['awb_response']['success'] == true){
                OrderTransport::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'user_id'           => $order->user_id,
                        'carrier_id'           => $request->carrier_id,
                        'transport_name'    => preg_replace('/\s*\(.*?\)/', '', $request->courier_name),
                        'transport_contact' => '',
                        'transport_url'     => 'https://rnvalves.shipway.com/track',
                        'order_tracking_id' => $reponse['awb_response']['AWB'],
                        'attachment' => $reponse['awb_response']['shipping_url']
                    ]
                );
                $order->package_length = $request->box_length;
                $order->package_breadth = $request->box_breadth;
                $order->package_height = $request->box_height;
                $order->package_weight = $request->box_weight;
                $order->delivery_charge = $request->delivery_charge;
                $order->cod_charge = $request->cod_charge;
                $order->gst_charge = $gstcharge;
                $order->total_delivery_charge = $gstcharge+$request->delivery_charge+$request->cod_charge;
                $order->save();
            }else{
                return back()->with('error', 'Something went wrong!')->withInput();
            }
            return back()->with('success', 'Order label generate successfully!');
        // }catch(\Exception $e){
        //     return back()->with('error', $e->getMessage());
        // }
     
    }
    public function GenerateManifest(Request $request)
    {
        try{
            $orderids = (string) "RNOD".$request->order_ids;
            $response = generate_manifest_shipway($orderids);
            $order = Order::find($request->order_ids);
            if(isset($response['status']) && $response['status'] == true){
                $order->manifest_ids = $response['manifest_ids'];
                $order->save();
            }
            return back()->with('success', 'Order manifest generate successfully!');

        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function markPaymentReceived(Order $order, Request $request)
    {
        $request->validate([
            'payment_note' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            if ($order->isPaid()) {
                return back()->with('error', 'Payment is already marked as received for this order.');
            }

            if (in_array($order->status, ['Completed', 'Cancelled'], true)) {
                return back()->with('error', 'Cannot update payment on a completed or cancelled order.');
            }

            $order->is_payment = 'Complete';
            if ($request->filled('payment_note')) {
                $order->payment_note = $request->payment_note;
            }
            $movedToInProgress = ($order->status === 'Pending');
            if ($movedToInProgress) {
                $order->status = 'In-Progress';
            }
            $order->save();

            OrderLog::create([
                'order_id' => $order->id,
                'user_id' => auth()->user()->id,
                'user_name' => auth()->user()->name,
                'change_value' => 'Payment Received (Manual)' . ($request->payment_note ? ': ' . $request->payment_note : ''),
                'change_type' => 'payment',
            ]);

            if ($movedToInProgress) {
                OrderLog::create([
                    'order_id' => $order->id,
                    'user_id' => auth()->user()->id,
                    'user_name' => auth()->user()->name,
                    'change_value' => 'In-Progress',
                    'change_type' => 'status',
                ]);
            }

            return back()->with('success', $movedToInProgress
                ? 'Payment marked as received. Order moved to In-Progress.'
                : 'Payment marked as received successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function setStorePickup(Order $order)
    {
        try {
            if ($order->isStorePickup()) {
                return back()->with('error', 'This order is already marked as Store Pickup.');
            }

            if (in_array($order->status, ['In-Transit', 'Delivered', 'Completed', 'Cancelled'], true)) {
                return back()->with('error', 'Cannot change fulfillment type for this order status.');
            }

            if (!empty($order->delivery_charge) && $order->delivery_charge > 0) {
                return back()->with('error', 'Cannot mark as Store Pickup after a shipping label has been generated.');
            }

            $order->fulfillment_type = 'Store Pickup';
            $order->save();

            OrderLog::create([
                'order_id' => $order->id,
                'user_id' => auth()->user()->id,
                'user_name' => auth()->user()->name,
                'change_value' => 'Store Pickup',
                'change_type' => 'fulfillment',
            ]);

            return back()->with('success', 'Order marked as Store Pickup. Shipway is no longer required.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function completeStorePickup(Order $order, Request $request)
    {
        $request->validate([
            'payment_note' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            if ($order->status === 'Completed') {
                return back()->with('error', 'This order is already completed.');
            }

            if (in_array($order->status, ['Cancelled'], true)) {
                return back()->with('error', 'Cannot complete a cancelled order.');
            }

            if (!empty($order->delivery_charge) && $order->delivery_charge > 0) {
                return back()->with('error', 'Cannot use Store Pickup — a Shipway shipping label already exists. Use parcel status buttons below.');
            }

            if (!$order->isStorePickup()) {
                $order->fulfillment_type = 'Store Pickup';
                OrderLog::create([
                    'order_id' => $order->id,
                    'user_id' => auth()->user()->id,
                    'user_name' => auth()->user()->name,
                    'change_value' => 'Store Pickup',
                    'change_type' => 'fulfillment',
                ]);
            }

            if (!$order->isPaid()) {
                $order->is_payment = 'Complete';
                if ($request->filled('payment_note')) {
                    $order->payment_note = $request->payment_note;
                }

                OrderLog::create([
                    'order_id' => $order->id,
                    'user_id' => auth()->user()->id,
                    'user_name' => auth()->user()->name,
                    'change_value' => 'Payment Received at Pickup' . ($request->payment_note ? ': ' . $request->payment_note : ''),
                    'change_type' => 'payment',
                ]);
            }

            $order->status = 'Completed';
            $order->save();

            OrderLog::create([
                'order_id' => $order->id,
                'user_id' => auth()->user()->id,
                'user_name' => auth()->user()->name,
                'change_value' => 'Completed (Customer collected from shop)',
                'change_type' => 'status',
            ]);

            return back()->with('success', 'Done — customer collected order from shop. Status: Completed.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function completeWithoutShipway(Order $order, Request $request)
    {
        $request->validate([
            'payment_note' => ['nullable', 'string', 'max:500'],
            'status_note' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            if ($order->status === 'Completed') {
                return back()->with('error', 'This order is already completed.');
            }

            if ($order->status === 'Cancelled') {
                return back()->with('error', 'Cannot complete a cancelled order.');
            }

            if (!empty($order->delivery_charge) && $order->delivery_charge > 0) {
                return back()->with('error', 'Shipway label already exists for this order.');
            }

            if (!$order->isPaid()) {
                $order->is_payment = 'Complete';
                if ($request->filled('payment_note')) {
                    $order->payment_note = $request->payment_note;
                }

                OrderLog::create([
                    'order_id' => $order->id,
                    'user_id' => auth()->user()->id,
                    'user_name' => auth()->user()->name,
                    'change_value' => 'Payment Received (Manual)' . ($request->payment_note ? ': ' . $request->payment_note : ''),
                    'change_type' => 'payment',
                ]);
            }

            $order->fulfillment_type = 'Manual Delivery';
            $order->status = 'Completed';
            $order->save();

            OrderLog::create([
                'order_id' => $order->id,
                'user_id' => auth()->user()->id,
                'user_name' => auth()->user()->name,
                'change_value' => 'Manual Delivery',
                'change_type' => 'fulfillment',
            ]);

            $logStatus = 'Completed (Delivered without Shipway)';
            if ($request->filled('status_note')) {
                $logStatus .= ' — ' . $request->status_note;
            }

            OrderLog::create([
                'order_id' => $order->id,
                'user_id' => auth()->user()->id,
                'user_name' => auth()->user()->name,
                'change_value' => $logStatus,
                'change_type' => 'status',
            ]);

            return back()->with('success', 'Order completed without Shipway.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateOrderStatus(Order $order, Request $request)
    {
        $request->validate([
            'status' => ['required', Rule::in(Order::orderStatuses())],
            'status_note' => ['nullable', 'string', 'max:500'],
            'confirm_shipway' => ['nullable', 'boolean'],
        ]);

        try {
            if ($order->status === 'Cancelled') {
                return back()->with('error', 'Cancelled orders cannot be updated.');
            }

            $newStatus = $request->status;
            $confirmShipway = $request->boolean('confirm_shipway');

            if ($order->requiresTransportForStatus($newStatus) && !$confirmShipway) {
                return back()->with('error', 'Transport/Shipway details missing. Tick "Already shipped via Shipway" to update status manually.');
            }

            $order->status = $newStatus;
            $order->save();

            $logValue = $newStatus;
            if ($request->filled('status_note')) {
                $logValue .= ' — ' . $request->status_note;
            }
            if ($confirmShipway && !$order->hasShipwayData()) {
                $logValue .= ' (Manual — Shipway confirmed by admin)';
            }

            OrderLog::create([
                'order_id' => $order->id,
                'user_id' => auth()->user()->id,
                'user_name' => auth()->user()->name,
                'change_value' => $logValue,
                'change_type' => 'status',
            ]);

            return back()->with('success', 'Order status updated to ' . $newStatus . '.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
