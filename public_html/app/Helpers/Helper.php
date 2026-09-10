<?php
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;
use OpenSpout\Common\Entity\Style\Style;
use Illuminate\Http\Request;
use App\Models\{
    ImportedFileLog,
    FrontPage,
    OrderItem,
    Category,
    Page,
    Order
};
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use GuzzleHttp\Client;

function export_fast_excel($sheet, $sheetname){
    @ini_set('memory_limit', '1024M');
    @set_time_limit(600);

	$header_style = (new Style())
        ->setFontBold()
        ->setFontSize(13)
        /*->setShouldWrapText()*/
        ->setBackgroundColor("EDEDED");

    $rows_style = (new Style())
        ->setFontSize(11);

    return (new FastExcel($sheet))
        ->headerStyle($header_style)
        ->rowsStyle($rows_style)
        ->download($sheetname);
}

function common_import_store(Request $request, $fieldname, $model_name){
	if( $request->hasFile( $fieldname ) ) {
		if (!$request->file($fieldname)->isValid()) {
            return back()->with('error_message', 'Invalid File!');
        }
		$attachment = $request->file($fieldname);
        $randomName = str()->random(30);
        $name = $attachment->getClientOriginalName();
        $fileName = str($name, '-')->append($randomName)->slug().'.'.$attachment->getClientOriginalExtension();
        $importPath = public_path('uploads/imports/');
        // Prevent upload failures when the directory is missing on fresh deployments.
        File::ensureDirectoryExists($importPath, 0775, true);
        $request->file($fieldname)->move($importPath, $fileName);
       	$filePath = 'uploads/imports/'.$fileName;

       	$auth_id = auth()->user()->id;
        
        ImportedFileLog::create([
        	'auth_id' => $auth_id,
        	'model_name' => $model_name,
        	'file_name' => $name,
        	'file_path' => $filePath,
        ]);
    }
	return null;
}

function frontPage(){
    return FrontPage::whereId(1)->first();
}
function isiImage(){
    return "https://rnvalves.media/Catalogue/isi.jpg";
}

/**
 * Compare product main vs gallery image URLs even when Excel / DB
 * store the same file with slight URL differences (domain, slash, case).
 */
function normalizeProductImageUrl(?string $url): string
{
    $url = trim((string) $url);
    if ($url === '') {
        return '';
    }

    $url = strtolower($url);
    $url = preg_replace('/[?#].*$/', '', $url) ?? $url;
    $url = str_replace('\\', '/', $url);
    $url = rtrim($url, '/');

    $path = parse_url($url, PHP_URL_PATH);
    if (is_string($path) && $path !== '') {
        return rtrim($path, '/');
    }

    return $url;
}

function ActiveCategories(){
    return Category::where(['status'=>'Active','is_visible_website'=>1])->orderBy('created_at','desc')->get();
}
function dynamicPage($url_key){
    return Page::where(['url_key'=>$url_key])->first();
}
function encryption($urlstring){
    return encrypt($urlstring);
}

function shipwayKey(){
    $token = base64_encode("rncom@rnvalves.com:9D57l172eMP15a67WB7O1h51j4dv1XD7");
    return $token;
}
function MSG91Key(){
    $token = '398545A53Mg3oXvN64c33f5aP1';
    return $token;
}
function MSG91Url(){
    $url = 'https://control.msg91.com/api/v5/';
    return $url;
}

function razorpay_link_cancel($pay_link_id){
    $client = new Client();
    try{
        return $client->post('https://api.razorpay.com/v1/payment_links/'.$pay_link_id.'/cancel', [
            'headers' => [
                'content-type' => 'application/json'
            ],
            'auth' => [trim(env('RAZORPAY_KEY')), trim(env('RAZORPAY_SECRET'))],
        ]);
    }catch(\Exception $e){
        return back()->with('error', $e->getMessage());
    }
}

function razorypay_resend_text_payment_link($pay_link_id){
    $client = new Client();
    return $client->post('https://api.razorpay.com/v1/payment_links/'.$pay_link_id.'/notify_by/sms', [
        'headers' => [
            'content-type' => 'application/json'
        ],
        'auth' => [trim(env('RAZORPAY_KEY')), trim(env('RAZORPAY_SECRET'))],
    ]);
}

function razorpay_post_order($order_id){
    $getOrder = Order::getSingleOrder($order_id);
    $client = new Client();
    if(!empty($getOrder)){
        try{
            return $client->post('https://api.razorpay.com/v1/orders', [
                'headers' => [
                    'content-type' => 'application/json',
                ],
                'auth' => [trim(env('RAZORPAY_KEY')), trim(env('RAZORPAY_SECRET'))],
                'json' => [
                    'amount' => (int) round($getOrder->total_amount * 100),
                    'currency' => 'INR',
                    'receipt' => 'receipt#'.$getOrder->id,
                    'notes' => [
                        'key1' => !empty($getOrder->name) ? $getOrder->name : 'Customer',
                        'key2' => !empty($getOrder->mobile) ? $getOrder->mobile : ''
                    ],
                ]
            ]);
        }catch(\GuzzleHttp\Exception\ClientException $e){
            throw new \Exception(trim($e->getResponse()->getBody()->getContents()));
        }catch(\Exception $e){
            throw new \Exception('Whoops! Something went wrong - '.$e->getMessage());
        }
    }
}

function razorpay_payment_link_create($order_id){
    $getOrder = Order::getSingleOrder($order_id);
    $client = new Client();
    if(!empty($getOrder)){
        try{
            $key = str()->uuid()->toString()."-".$getOrder->id;
            $customerName = !empty($getOrder->name) ? $getOrder->name : 'Customer';
            $customerMobile = !empty($getOrder->mobile) ? $getOrder->mobile : '9999999999';
            $customerEmail = (!empty($getOrder->email) && filter_var($getOrder->email, FILTER_VALIDATE_EMAIL)) ? $getOrder->email : 'noreply@rnvalves.com';

            $payment_link_response = $client->post('https://api.razorpay.com/v1/payment_links/', [
                'headers' => [
                    'Content-type' => 'application/json'
                ],
                'auth' => [trim(env('RAZORPAY_KEY')), trim(env('RAZORPAY_SECRET'))],
                'json' => [
                    'amount' => (int) round($getOrder->total_amount*100),
                    'currency' => 'INR',
                    'accept_partial' => false,
                    'reference_id' => $getOrder->uuid,
                    'description' => $key,
                    'customer' => [
                        'name' => $customerName,
                        'contact' => $customerMobile,
                        'email' => $customerEmail,
                    ],
                    'notify' => [
                        'sms' => true,
                        'email' => true,
                        'whatsapp' => true,
                    ],
                    'reminder_enable' => true,
                    'notes' => [
                        'policy_name' => "RN Valves & Faucets E-commerce",
                    ],
                    'callback_url' => url('razorypay/success-order-payment'),
                    'callback_method' => 'get'
                ]
            ]);

            return json_decode($payment_link_response->getBody());
        }catch(\GuzzleHttp\Exception\ClientException $e){
            throw new \Exception(trim($e->getResponse()->getBody()->getContents()));
        }catch(\Exception $e){
            throw new \Exception('Whoops! Something went wrong - '.$e->getMessage());
        }
    }else{
        abort(404);
    }                     
}

function order_push_shipway($order,$request)
{

    $orderItems = OrderItem::where('order_id',$order->id)->get();
    $products = [];
    foreach ($orderItems as $item) {
        $products[] = [
            "product" => $item->product->name, 
            "price" => (string) $item->product->in_mrp,
            "product_code" => $item->product_code,
            "product_quantity" => (string) $item->total_qty,
            "discount" => "0", 
            "tax_rate" => "0", 
            "tax_title" => "IGST"
        ];
    }
    $paymentMode = ($order->payment_term == 'Prepaid') ? "P" : "C";
    $orderWeight = floatval($request->box_weight) * 1000;
    $token = shipwayKey();
    $client = new Client();
    $headers = [
      'Authorization' => 'Basic '. $token,
      'Content-Type' => 'application/json'
    ];
    $body = json_encode([
        "order_id" => (string) 'RNOD'.$order->id,
        "carrier_id" => $request->carrier_id,
        "warehouse_id" => "60832",
        "return_warehouse_id" => "60832",
        "products" => $products,
        "discount" => (string) $order->discount_amount,
        "shipping" => $order->shipping_amount,
        "order_total" => $order->total_amount,
        "gift_card_amt" => "0",
        "taxes" => "0",
        "payment_type" => $paymentMode,
        "email" => $order->email,
        "billing_address" => $order->booking_address,
        "billing_city" => $order->city,
        "billing_state" => $order->state,
        "billing_country" => $order->country,
        "billing_firstname" => $order->name,
        "billing_phone" => $order->mobile,
        "billing_zipcode" => $order->zipcode,
        "shipping_address" => $order->booking_address,
        "shipping_city" => $order->city,
        "shipping_state" => $order->state,
        "shipping_country" => $order->country,
        "shipping_firstname" => $order->name,
        "shipping_phone" => $order->mobile,
        "shipping_zipcode" => $order->zipcode,
        "order_weight" => (string) $orderWeight ?? "0",
        "box_length" => (string) $request->box_length ?? "0",
        "box_breadth" => (string) $request->box_breadth ?? "0",
        "box_height" => (string) $request->box_height ?? "0",
        "order_date" => $order->created_at->format('Y-m-d H:i:s'),
    ], JSON_UNESCAPED_SLASHES);
    
    $response = $client->post('https://app.shipway.com/api/v2orders', [
        'headers' => $headers,
        'body' => $body
    ]);
    $responseBody = $response->getBody()->getContents();
    $responseData = json_decode($responseBody, true);
    // dd($responseData);
    return $responseData;
    
}

function order_cancel_shipway($order)
{
    $orderid = 'RNOD';
    $awbno = '0';
    if($order->status == 'Status Pending' || $order->status == 'Pending'){
        $orderid .= $order->id;
        $apiurl = 'https://app.shipway.com/api/Cancelorders';
        $body = json_encode([   
            "order_ids" => [$orderid],   
        ], JSON_UNESCAPED_SLASHES);
    }elseif(@$order->orderTransort->order_tracking_id){
        $awbno = (string) $order->orderTransort->order_tracking_id;
        $apiurl = 'https://app.shipway.com/api/Cancel';
        $body = json_encode([   
            "awb_number" => [$awbno],   
        ], JSON_UNESCAPED_SLASHES);
    }
    $token = shipwayKey();
    $client = new Client();
    $headers = [
      'Authorization' => 'Basic '. $token,
      'Content-Type' => 'application/json'
    ];
 
    $response = $client->post($apiurl, [
        'headers' => $headers,
        'body' => $body
    ]);
    return $response->getBody()->getContents();

}

function generate_manifest_shipway($orderids)
{
    $token = shipwayKey();
    $client = new Client();
    $headers = [
      'Authorization' => 'Basic '. $token,
      'Content-Type' => 'application/json'
    ];
    $body = json_encode([
        "order_ids" => [$orderids],   
    ], JSON_UNESCAPED_SLASHES);
  
    $response = $client->post('https://app.shipway.com/api/Createmanifest', [
        'headers' => $headers,
        'body' => $body
    ]);
    $responseBody = $response->getBody()->getContents();
    return json_decode($responseBody, true);


}

function order_return_shipway($order,$request)
{
    $orderItems = OrderItem::where('order_id',$order->id)->get();

    $products = [];
    $productImages = implode(',',$request->images);

    foreach ($orderItems as $item) {
        $products[] = [
            "product" => $item->product->name, 
            "price" => (string) $item->product->in_mrp,
            "product_code" => $item->product_code,
            "product_quantity" => (string) $item->total_qty,
            "discount" => "0", 
            "tax_rate" => "0", 
            "tax_title" => "IGST",
            "variants" => (string) $item->product->color_name
        ];
    }
    $paymentMode = ($order->payment_term == 'Prepaid') ? "P" : "C";

    $token = shipwayKey();
    $client = new Client();
    $headers = [
      'Authorization' => 'Basic '. $token,
      'Content-Type' => 'application/json'
    ];
    // $refundId = 0;
    // $tranferDetails = [];
    // if($request->return_status == 'R'){
    //     $refundId = $request->refund_payment_id > 0 ? $request->refund_payment_id : 0;
    //     if($refundId == 1){
    //         $tranferDetails[] = [
    //            'account_number' => $request->account_number,
    //            'bank_name' => $request->bank_name,
    //            'ifsc_code' => $request->ifsc_code,
    //            'account_holder_name' => $request->account_holder_name,
    //         ];

    //     }elseif($refundId == 2){
    //         $tranferDetails[] = [
    //             'upi' => $request->upi_id
    //         ];
    //     }elseif($refundId == 3){
    //         $tranferDetails[] = [
    //             'paytm' => $request->paytm
    //         ];
    //     }
    // }
    $body = json_encode([
        "order_id" => (string) 'RNOD'.$order->id,
        "return_order_status" => (string) 'E',//$request->return_status,
        "return_reason_id" => 0,
        // "refund_payment_id" => $refundId,
        // "transfer_details" => $tranferDetails,
        "return_products_images" => [$productImages],
        "customer_notes" => (string) $request->customer_notes,
        "products" => $products,
        "discount" => (string) $order->discount_amount,
        "shipping" => $order->shipping_amount,
        "order_total" => $order->total_amount,
        "gift_card_amt" => "0",
        "taxes" => "0",
        "payment_type" => $paymentMode,
        "email" => $order->email,
        "billing_address" => $order->booking_address,
        "billing_city" => $order->city,
        "billing_state" => $order->state,
        "billing_country" => $order->country,
        "billing_firstname" => $order->name,
        "billing_phone" => $order->mobile,
        "billing_zipcode" => $order->zipcode,
        "shipping_address" => $order->booking_address,
        "shipping_city" => $order->city,
        "shipping_state" => $order->state,
        "shipping_country" => $order->country,
        "shipping_firstname" => $order->name,
        "shipping_phone" => $order->mobile,
        "shipping_zipcode" => $order->zipcode,
        "order_weight" => (string) $order->package_weight ?? "0",
        "box_length" => (string) $order->package_length ?? "0",
        "box_breadth" => (string) $order->package_breadth ?? "0",
        "box_height" => (string) $order->package_height ?? "0",
        "order_date" => (string) date('Y-m-d H:i:s',strtotime($order->created_at)),
    ], JSON_UNESCAPED_SLASHES);
    $response = $client->post('https://app.shipway.com/api/Cancelorders', [
        'headers' => $headers,
        'body' => $body
    ]);
    $responseBody = $response->getBody()->getContents();
    return json_decode($responseBody, true);

}

function SendSMS($templateid='',$params = [])
    {
        try{
            $authKey = MSG91Key();
            $url = MSG91Url();
            $client = new Client();
            $headers = [
              'authkey' => (string)$authKey,
              'accept' => 'application/json',
              'content-type' => 'application/json'
            ];
            $body = json_encode([
                "template_id" => (string)$templateid,   
                "short_url" => '1',   
                "realTimeResponse" => '1',   
                "recipients" => [$params],     
            ], JSON_UNESCAPED_SLASHES);
            $response = $client->post($url.'flow', [
                'headers' => $headers,
                'body' => $body
            ]);
            $responseBody = $response->getBody()->getContents();
            $decodeData = json_decode($responseBody,true);
            if($decodeData['type'] == 'success'){
               $success = true;
               $message = 'SMS sent successfully!';
            }else{
                $success = false;
                $message = 'Something went wrong!';
            }
            return $responseBody;
        }catch(\Exception $e){
            return $e->getMessage();
        }
       
    }

function shiprocketToken(){
    $token = \Illuminate\Support\Facades\Cache::get('shiprocket_api_jwt_token');
    if(!empty($token)){
        return $token;
    }

    $email = config('services.shiprocket.email', env('SHIPROCKET_EMAIL'));
    $password = config('services.shiprocket.password', env('SHIPROCKET_PASSWORD'));
    if (empty($email) || empty($password)) {
        \Illuminate\Support\Facades\Log::error('Shiprocket credentials missing in environment (.env).');
        return null;
    }

    $client = new Client();
    try {
        $response = $client->post('https://apiv2.shiprocket.in/v1/external/auth/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => $email,
                'password' => $password,
            ],
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        if(!empty($data['token'])){
            \Illuminate\Support\Facades\Cache::put('shiprocket_api_jwt_token', $data['token'], now()->addDays(7));
            return $data['token'];
        }
        return null;
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Shiprocket Auth Error: ' . $e->getMessage());
        return null;
    }
}

function get_shiprocket_rates($order, $request)
{
    $token = shiprocketToken();
    if (!$token) {
        \Illuminate\Support\Facades\Cache::forget('shiprocket_api_jwt_token');
        $token = shiprocketToken();
        if (!$token) {
            return [
                'success' => false,
                'error' => 'Failed to authenticate with Shiprocket API.',
            ];
        }
    }

    $client = new Client();
    $paymentMode = ($order->payment_term == 'Prepaid') ? 0 : 1;
    $weightInKg = floatval($request->weight);
    if ($weightInKg <= 0) {
        $weightInKg = 0.5;
    }

    $pickupPincode = config('services.shiprocket.pickup_pincode', 201010);
    $deliveryPincode = (int) $order->zipcode;

    $queryParams = http_build_query([
        'pickup_postcode' => $pickupPincode,
        'delivery_postcode' => $deliveryPincode,
        'weight' => $weightInKg,
        'cod' => $paymentMode,
        'declared_value' => (int) $order->total_amount,
        'is_return' => 0,
        'length' => floatval($request->length) > 0 ? floatval($request->length) : 10,
        'breadth' => floatval($request->breadth) > 0 ? floatval($request->breadth) : 10,
        'height' => floatval($request->height) > 0 ? floatval($request->height) : 10,
    ]);

    try {
        $response = $client->get('https://apiv2.shiprocket.in/v1/external/courier/serviceability/?' . $queryParams, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        if (!isset($data['data']['available_courier_companies']) || empty($data['data']['available_courier_companies'])) {
            return [
                'success' => false,
                'error' => 'No Shiprocket courier service available for this pincode (' . $deliveryPincode . ').',
            ];
        }

        $options = "<option value=''>Select Courier (Shiprocket)</option>";
        foreach ($data['data']['available_courier_companies'] as $rate) {
            $deliveryCharge = floatval($rate['rate']);
            $gstCharge = round($deliveryCharge * 18 / 100, 2);
            $totalDeliveryCharge = round($gstCharge + $deliveryCharge, 2);
            $codCharge = isset($rate['cod_charges']) ? floatval($rate['cod_charges']) : 0;
            $etd = !empty($rate['etd']) ? " (ETD: " . $rate['etd'] . ")" : "";

            $options .= "<option value='{$rate['courier_company_id']}' data-courier-name='{$rate['courier_name']}' data-delivery-charge='{$deliveryCharge}' data-cod-charge='{$codCharge}' data-provider='shiprocket'>";
            $options .= "{$rate['courier_name']} - ₹ {$totalDeliveryCharge}{$etd}";
            if ($order->payment_term == 'COD' && $codCharge > 0) {
                $options .= " (COD: ₹ {$codCharge})";
            }
            $options .= "</option>";
        }

        return [
            'success' => true,
            'all' => $data['data']['available_courier_companies'],
            'html' => $options,
            'message' => 'Shiprocket couriers fetched successfully',
        ];
    } catch (\GuzzleHttp\Exception\ClientException $e) {
        $body = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
        \Illuminate\Support\Facades\Log::error('Shiprocket Rate Error: ' . $body);
        return [
            'success' => false,
            'error' => 'Shiprocket error: ' . $body,
        ];
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Shiprocket Rate Error: ' . $e->getMessage());
        return [
            'success' => false,
            'error' => $e->getMessage(),
        ];
    }
}

function get_shiprocket_pickup_location($token)
{
    $location = config('services.shiprocket.pickup_location', env('SHIPROCKET_PICKUP_LOCATION'));
    if (!empty($location) && $location !== 'Home') {
        return $location;
    }

    return \Illuminate\Support\Facades\Cache::remember('shiprocket_primary_pickup_location', 60 * 60 * 24, function () use ($token) {
        try {
            $client = new Client();
            $res = $client->get('https://apiv2.shiprocket.in/v1/external/settings/company/pickup', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type'  => 'application/json',
                ],
            ]);
            $data = json_decode($res->getBody()->getContents(), true);
            if (!empty($data['data']['shipping_address'])) {
                foreach ($data['data']['shipping_address'] as $addr) {
                    if (!empty($addr['is_primary_location'])) {
                        return $addr['pickup_location'];
                    }
                }
                return $data['data']['shipping_address'][0]['pickup_location'] ?? 'Office';
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Shiprocket fetch pickup location error: ' . $e->getMessage());
        }
        return 'Office';
    });
}

function order_push_shiprocket($order, $request)
{
    $token = shiprocketToken();
    if (!$token) {
        \Illuminate\Support\Facades\Cache::forget('shiprocket_api_jwt_token');
        $token = shiprocketToken();
        if (!$token) {
            return ['status' => false, 'message' => 'Shiprocket authentication failed.'];
        }
    }

    $client = new Client();
    $headers = [
        'Authorization' => 'Bearer ' . $token,
        'Content-Type' => 'application/json',
    ];

    $orderItems = OrderItem::where('order_id', $order->id)->get();
    $items = [];
    foreach ($orderItems as $item) {
        $items[] = [
            'name' => !empty($item->product->name) ? $item->product->name : ('Product ' . $item->product_code),
            'sku' => (string) $item->product_code,
            'units' => (int) $item->total_qty,
            'selling_price' => (float) $item->price,
            'discount' => 0,
            'tax' => 0,
            'hsn' => !empty($item->product->hsn) ? (string) $item->product->hsn : '',
        ];
    }

    $paymentMethod = ($order->payment_term == 'Prepaid') ? 'Prepaid' : 'COD';
    $pickupLocation = get_shiprocket_pickup_location($token);

    $billingEmail = (!empty($order->email) && filter_var($order->email, FILTER_VALIDATE_EMAIL)) ? $order->email : (config('services.shiprocket.email') ?: 'billing@rnvalves.com');
    $billingPhone = preg_replace('/[^0-9]/', '', (string)$order->mobile);
    if (strlen($billingPhone) > 10) {
        $billingPhone = substr($billingPhone, -10);
    }

    $boxLength = floatval($request->box_length) > 0 ? floatval($request->box_length) : 10;
    $boxBreadth = floatval($request->box_breadth) > 0 ? floatval($request->box_breadth) : 10;
    $boxHeight = floatval($request->box_height) > 0 ? floatval($request->box_height) : 10;
    $boxWeight = floatval($request->box_weight) > 0 ? floatval($request->box_weight) : 0.5;

    $payload = [
        'order_id' => 'RNOD' . $order->id,
        'order_date' => $order->created_at->format('Y-m-d H:i'),
        'pickup_location' => $pickupLocation,
        'channel_id' => '',
        'comment' => (string) ($order->note ?? ''),
        'billing_customer_name' => (string) ($order->name ?? 'Customer'),
        'billing_last_name' => '',
        'billing_address' => (string) ($order->booking_address ?? ''),
        'billing_address_2' => '',
        'billing_city' => (string) ($order->city ?? ''),
        'billing_pincode' => (int) $order->zipcode,
        'billing_state' => (string) ($order->state ?? ''),
        'billing_country' => (string) ($order->country ?? 'India'),
        'billing_email' => $billingEmail,
        'billing_phone' => $billingPhone,
        'shipping_is_billing' => true,
        'shipping_customer_name' => (string) ($order->name ?? 'Customer'),
        'shipping_last_name' => '',
        'shipping_address' => (string) ($order->booking_address ?? ''),
        'shipping_address_2' => '',
        'shipping_city' => (string) ($order->city ?? ''),
        'shipping_pincode' => (int) $order->zipcode,
        'shipping_country' => (string) ($order->country ?? 'India'),
        'shipping_state' => (string) ($order->state ?? ''),
        'shipping_email' => $billingEmail,
        'shipping_phone' => $billingPhone,
        'order_items' => $items,
        'payment_method' => $paymentMethod,
        'shipping_charges' => (float) ($order->shipping_amount ?? 0),
        'giftwrap_charges' => 0,
        'transaction_charges' => 0,
        'total_discount' => (float) ($order->discount_amount ?? 0),
        'sub_total' => (float) $order->total_amount,
        'length' => $boxLength,
        'breadth' => $boxBreadth,
        'height' => $boxHeight,
        'weight' => $boxWeight,
    ];

    try {
        // Step 1: Create Order Adhoc
        $response = $client->post('https://apiv2.shiprocket.in/v1/external/orders/create/adhoc', [
            'headers' => $headers,
            'json' => $payload,
        ]);
        $orderData = json_decode($response->getBody()->getContents(), true);

        // Auto-retry if pickup location mismatch
        if (empty($orderData['shipment_id']) && isset($orderData['message']) && str_contains(strtolower($orderData['message']), 'pickup location')) {
            \Illuminate\Support\Facades\Cache::forget('shiprocket_primary_pickup_location');
            $retryPickupLocation = get_shiprocket_pickup_location($token);
            if ($retryPickupLocation !== $pickupLocation) {
                $payload['pickup_location'] = $retryPickupLocation;
                $retryRes = $client->post('https://apiv2.shiprocket.in/v1/external/orders/create/adhoc', [
                    'headers' => $headers,
                    'json' => $payload,
                ]);
                $orderData = json_decode($retryRes->getBody()->getContents(), true);
            }
        }

        if (empty($orderData['shipment_id'])) {
            $msg = $orderData['message'] ?? 'Failed to create order on Shiprocket.';
            if (isset($orderData['errors']) && is_array($orderData['errors'])) {
                $msg .= ' ' . json_encode($orderData['errors']);
            }
            return ['status' => false, 'message' => $msg];
        }

        $shipmentId = $orderData['shipment_id'];
        $srOrderId = $orderData['order_id'] ?? null;

        // Step 2: Assign Courier / AWB
        $awbCode = null;
        $courierName = $request->courier_name;
        if (!empty($request->carrier_id)) {
            $awbRes = $client->post('https://apiv2.shiprocket.in/v1/external/courier/assign/awb', [
                'headers' => $headers,
                'json' => [
                    'shipment_id' => $shipmentId,
                    'courier_id' => (int) $request->carrier_id,
                ],
            ]);
            $awbData = json_decode($awbRes->getBody()->getContents(), true);
            if (isset($awbData['response']['data']['awb_code'])) {
                $awbCode = $awbData['response']['data']['awb_code'];
                $courierName = $awbData['response']['data']['courier_name'] ?? $courierName;
            } elseif (isset($awbData['awb_assign_status']) && $awbData['awb_assign_status'] == 0) {
                return ['status' => false, 'message' => 'AWB assignment failed: ' . ($awbData['response']['data']['awb_assign_error'] ?? json_encode($awbData))];
            }
        }

        // Step 3: Generate Label
        $labelUrl = null;
        try {
            $labelRes = $client->post('https://apiv2.shiprocket.in/v1/external/courier/generate/label', [
                'headers' => $headers,
                'json' => [
                    'shipment_id' => [$shipmentId],
                ],
            ]);
            $labelData = json_decode($labelRes->getBody()->getContents(), true);
            $labelUrl = $labelData['label_url'] ?? null;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Shiprocket label generation warning: ' . $e->getMessage());
        }

        // Step 4: Request Pickup
        try {
            $client->post('https://apiv2.shiprocket.in/v1/external/courier/generate/pickup', [
                'headers' => $headers,
                'json' => [
                    'shipment_id' => [$shipmentId],
                ],
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Shiprocket pickup generation warning: ' . $e->getMessage());
        }

        return [
            'status' => true,
            'awb' => $awbCode,
            'shipping_url' => $labelUrl,
            'shipment_id' => $shipmentId,
            'sr_order_id' => $srOrderId,
            'courier_name' => $courierName,
            'tracking_url' => 'https://shiprocket.co/tracking/' . $awbCode,
        ];
    } catch (\GuzzleHttp\Exception\ClientException $e) {
        $body = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
        \Illuminate\Support\Facades\Log::error('Shiprocket Create Order Error: ' . $body);
        return ['status' => false, 'message' => 'Shiprocket Error: ' . $body];
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Shiprocket Create Order Exception: ' . $e->getMessage());
        return ['status' => false, 'message' => $e->getMessage()];
    }
}

function order_cancel_shiprocket($order)
{
    $token = shiprocketToken();
    if (!$token) return null;

    $client = new Client();
    $headers = [
        'Authorization' => 'Bearer ' . $token,
        'Content-Type' => 'application/json',
    ];

    try {
        if (!empty($order->orderTransort->order_tracking_id)) {
            $response = $client->post('https://apiv2.shiprocket.in/v1/external/orders/cancel/shipment/awbs', [
                'headers' => $headers,
                'json' => [
                    'awbs' => [(string) $order->orderTransort->order_tracking_id]
                ]
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } else {
            $response = $client->post('https://apiv2.shiprocket.in/v1/external/orders/cancel', [
                'headers' => $headers,
                'json' => [
                    'ids' => ['RNOD' . $order->id]
                ]
            ]);
            return json_decode($response->getBody()->getContents(), true);
        }
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Shiprocket Cancel Error: ' . $e->getMessage());
        return null;
    }
}

function generate_manifest_shiprocket($shipmentId)
{
    $token = shiprocketToken();
    if (!$token) return ['status' => false, 'message' => 'Auth failed'];

    $client = new Client();
    try {
        $response = $client->post('https://apiv2.shiprocket.in/v1/external/manifests/generate', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'shipment_id' => is_array($shipmentId) ? $shipmentId : [$shipmentId]
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Shiprocket Manifest Error: ' . $e->getMessage());
        return ['status' => false, 'message' => $e->getMessage()];
    }
}

function order_cancel_shipping($order)
{
    if (!empty($order->orderTransort)) {
        if (str_contains(strtolower($order->orderTransort->transport_name ?? ''), 'shiprocket') ||
            str_contains(strtolower($order->orderTransort->transport_url ?? ''), 'shiprocket')) {
            return order_cancel_shiprocket($order);
        }
    }
    return order_cancel_shipway($order);
}

?>