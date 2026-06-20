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
        $this->middleware(['permission:order-edit'], ['only' => ['edit', 'update']]);
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

                if(!empty($order_transport)){
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
                $order->email = $user->email;
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
}
