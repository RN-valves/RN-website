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
            'auth' => [env('RAZORPAY_KEY'), env('RAZORPAY_SECRET')],
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
        'auth' => [env('RAZORPAY_KEY'), env('RAZORPAY_SECRET')],
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
                'auth' => [env('RAZORPAY_KEY'), env('RAZORPAY_SECRET')],
                'json' => [
                    'amount' => $getOrder->total_amount,
                    'currency' => 'INR',
                    'receipt' => 'receipt#'.$getOrder->id,
                    'notes' => [
                    'key1' => $getOrder->name,
                    'key2' => $getOrder->mobile
                    ],
                ]
            ]);
        }catch(\Exception $e){
            return back()->with('error', 'Whoops! Something went wrong -'.$e->getMessage());
        }
    }
}

function razorpay_payment_link_create($order_id){
    $getOrder = Order::getSingleOrder($order_id);
    $client = new Client();
    if(!empty($getOrder)){
        try{
            $key = str()->uuid()->toString()."-".$getOrder->id;
            $payment_link_response = $client->post('https://api.razorpay.com/v1/payment_links/', [
                'headers' => [
                    'Content-type' => 'application/json'
                ],
                'auth' => [env('RAZORPAY_KEY'), env('RAZORPAY_SECRET')],
                'json' => [
                    'amount' => $getOrder->total_amount*100,
                    'currency' => 'INR',
                    'accept_partial' => false,
                    'first_min_partial_amount' => $getOrder->total_amount*100,
                    'reference_id' => $getOrder->uuid,
                    'description' => $key,
                    'customer' => [
                        'name' => $getOrder->name,
                        'contact' => $getOrder->mobile,
                        'email' => $getOrder->email,
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
        }catch(\Exception $e){
            return back()->with('error', 'Whoops! Something went wrong -'.$e->getMessage());
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

?>