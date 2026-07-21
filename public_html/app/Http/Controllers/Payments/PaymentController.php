<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Product,
    Discount,
    ShippingCharge,
    Pincode,
    UserAddress,
    Order,
    OrderItem,
    OrderLog,
    Payment
};
use Cart;
use GuzzleHttp\Client;
use App\Mail\{
    DirectPaymentMail,
    OrderInvoiceMail
};
use Mail;
use App\Traits\DefaultTrait;
use App\Rules\GoogleReCaptcha;

class PaymentController extends Controller
{
    use DefaultTrait;

    public function cart(){
        try{
            $cartItems = Cart::content();

            // Fetch product details from the database
            $products = Product::whereIn('id', $cartItems->pluck('id'))->get()->keyBy('id');
            $cartItems = $cartItems->map(function ($item) use ($products) {
                $product = $products[$item->id] ?? null;
        
                return [
                    'id' => $item->id,
                    'name' => $product->name,
                    'price' => $product->in_mrp,
                    'quantity' => $item->qty,
                    'brand' => $product->brand ?? 'Default Brand',
                    'category' => $product->category->name ?? 'Default Category',
                    'subcategory' => $product->subcategory->name ?? 'Default Category',
                    'discount' => $product->discount ?? 0
                ];
            });
             
            $totalPrice = 0;
            $nextDiscount = '';
            if(Cart::content()->count() > 0){
                $totalPrice = (float) str_replace(',', '', Cart::priceTotal());
                $currentDiscount = Discount::where('start_value', '<=', $totalPrice)
                    ->where('end_value', '>=', $totalPrice)
                    ->first();
                   
                $nextDiscount = $currentDiscount ? Discount::find($currentDiscount->id + 1) : null;
    
                $firstDiscount = Discount::find(1);
                if($firstDiscount->start_value > $totalPrice){
                  $nextDiscount = $firstDiscount;
                }
            }

            return view('users.websites.cart',compact('cartItems','totalPrice','nextDiscount'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function addToCart(Request $request){
        if($request->isMethod("post")){
            $request->validate([
                'product_id' => ['required','exists:products,id'],
                'quantity' => ['required','numeric'],
            ],
            [
                'product_id.required' => 'You need to select the size first!',
                'product_id.exists' => 'Selected Product size is invalid, please try again!',
                'quantity.required' => 'You need enter atleast one quantity!'
            ]);
            try{
                $data = $request->only('product_id','quantity','sku_code');
                $getSingleProId = Product::getSingleProId($data['product_id']);
                if(!empty($getSingleProId)){

                    /*if($data['quantity']==$getSingleProId->productAttribute->inner_pcs || $data['quantity']>$getSingleProId->productAttribute->inner_pcs){
                        $data['quantity'] = $data['quantity'];
                    }else{
                        $data['quantity'] = $getSingleProId->productAttribute->inner_pcs;
                    }*/

                    $cartSubTotal = Cart::subtotal();

                    if((int) $cartSubTotal >= 350){
                        $data['quantity'] = $data['quantity'];
                    }else{
                        $data['quantity'] = $getSingleProId->productAttribute->moq;
                    }

                    if(!empty($data['sku_code'])){
                        $skuCode = $data['sku_code'];
                     }else{
                         
                         $skuCode = $getSingleProId->sku_code;
                     }
 
                    $cart = Cart::add(
                        [
                            'id' => $getSingleProId->id, 
                            'name' => $getSingleProId->name, 
                            'qty' => $data['quantity'], 
                            'price' => $getSingleProId->in_mrp, 
                            'weight' => $getSingleProId['productAttribute']['product_lbh_weight_gm']??0, 
                            'options' => [
                                'size' => $getSingleProId->size,
                                'color' => $getSingleProId->color_name,
                                'product_code' => $skuCode,
                            ]
                        ]
                    );

                    if($request->buy_now){
                        return redirect()->route('CartCheckout');
                    }
                    $totalPrice = (float) str_replace(',', '', Cart::priceTotal());
       
                    $currentDiscount = Discount::where('start_value', '<=', $totalPrice)
                        ->where('end_value', '>=', $totalPrice)
                        ->first();
                       
                    $nextDiscount = $currentDiscount ? Discount::find($currentDiscount->id + 1) : null;
    
                    $firstDiscount = Discount::find(1);
                    if($firstDiscount->start_value > $totalPrice){
                      $nextDiscount = $firstDiscount;
                    }
                    $discountText = '';
                    if($nextDiscount){
                        $discountAmount = $nextDiscount->start_value - $totalPrice;
                        $discountText = <<<HTML
                         <p class="discount-message">
                             <b>Add products worth ₹$discountAmount more to unlock a discount of {$nextDiscount->value}%!</b>
                         </p>
                         HTML;
                    }
                    return response()->json([
                        'status' => true,
                        'message' => 'Product has been added to cart successfully!',
                        'totalCartItems' => Cart::content()->count(),
                        'discountText' => $discountText,
                    ], 200);
                }else{
                    abort(404);
                }
            }catch(\Exception $e){
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                ], 500);
                return back()->with('error', $e->getMessage());
            }
        }
    }

    public function cartRemoveItem(Request $request){
        if($request->isMethod("post")){
            Cart::remove($request->cartid);
            $totalPrice = 0;
            $nextDiscount = '';
            if(Cart::content()->count() > 0){
                $totalPrice = (float) str_replace(',', '', Cart::priceTotal());
                $currentDiscount = Discount::where('start_value', '<=', $totalPrice)
                    ->where('end_value', '>=', $totalPrice)
                    ->first();
                   
                $nextDiscount = $currentDiscount ? Discount::find($currentDiscount->id + 1) : null;
    
                $firstDiscount = Discount::find(1);
                if($firstDiscount->start_value > $totalPrice){
                  $nextDiscount = $firstDiscount;
                }
            }
            return response()->json([
                'status' => true,
                'totalCartItems' => Cart::content()->count(),
                'success' => view('users.websites.carts.cart_items', [
                    'CartItems' => Cart::content(),
                    'totalPrice' => $totalPrice,
                    'nextDiscount' => $nextDiscount,
                ])->render(),
            ], 200);
        }
    }

    public function cartUpdate(Request $request){
        if($request->isMethod("post")){
            $cart = Cart::update($request->cartid, [
                'qty' => $request['new_qty'], 
            ]);

            $totalPrice = 0;
            $nextDiscount = '';
            if(Cart::content()->count() > 0){
                $totalPrice = (float) str_replace(',', '', Cart::priceTotal());
                $currentDiscount = Discount::where('start_value', '<=', $totalPrice)
                    ->where('end_value', '>=', $totalPrice)
                    ->first();
                   
                $nextDiscount = $currentDiscount ? Discount::find($currentDiscount->id + 1) : null;
    
                $firstDiscount = Discount::find(1);
                if($firstDiscount->start_value > $totalPrice){
                  $nextDiscount = $firstDiscount;
                }
            }

            return response()->json([
                'status' => true,
                'success' => view('users.websites.carts.cart_items', [
                    'CartItems' => Cart::content(),
                    'totalPrice' => $totalPrice,
                    'nextDiscount' => $nextDiscount,
                ])->render(),
            ], 200);
        }
    }

    public function cartEmpty(){
        try{
            Cart::destroy();
            return back()->with('emptyCart', 'Cart has been empty successfully!!');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function CartCheckout(Request $request){
        try{
          
            if(auth()->check()){
                $totalPrice = 0;
                $nextDiscount = '';
                if(Cart::content()->count() > 0){
                    $totalPrice = (float) str_replace(',', '', Cart::priceTotal());
                    $currentDiscount = Discount::where('start_value', '<=', $totalPrice)
                        ->where('end_value', '>=', $totalPrice)
                        ->first();
                       
                    $nextDiscount = $currentDiscount ? Discount::find($currentDiscount->id + 1) : null;
        
                    $firstDiscount = Discount::find(1);
                    if($firstDiscount->start_value > $totalPrice){
                      $nextDiscount = $firstDiscount;
                    }
                }
                if(Cart::count()>0){
                    if($request->discode){
                        $encryptCode = $request->discode;
                        $decryptCode = decrypt($encryptCode);
                        $getDiscount = Discount::checkDiscount($decryptCode);
                        $cartSubTotal = Cart::subtotal(2, '.', '');
                        $getActiveSlabDiscountCode = Discount::getActiveSlabDiscountCode();

                        if(!empty($getActiveSlabDiscountCode)){
                            if($getDiscount->type=="Amount"){
                                $discount_amount = $getDiscount->value;
                                $total_payble = $cartSubTotal - $getDiscount->value;
                            }else{
                                $discount_amount = ($cartSubTotal*$getDiscount->value)/100;
                                $total_payble = $cartSubTotal - $discount_amount;
                            }
                        }
                        $decryptAmount = $total_payble;
                        $decryptDisAmount = $discount_amount;

                        return view('users.websites.checkout',compact('decryptAmount','decryptDisAmount','decryptCode','totalPrice','nextDiscount'));
                    }
                    return view('users.websites.checkout',compact('totalPrice','nextDiscount'));
                }else{
                    return redirect(route('cart'));
                }
            }else{
                return redirect()->route('login');
            }
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function cartApplyDiscount(Request $request){
        if($request->isMethod("post")){
            $getDiscount = Discount::checkDiscount($request->discount_code);

            if(!empty($getDiscount)){
                $cartSubTotal = Cart::subtotal(2, '.', '');

                $getActiveSlabDiscountCode = Discount::getActiveSlabDiscountCode();

                if(!empty($getActiveSlabDiscountCode)){
                    if($getDiscount->type=="Amount"){
                        $discount_amount = $getDiscount->value;
                        $total_payble = $cartSubTotal - $getDiscount->value;
                    }else{
                        $discount_amount = ($cartSubTotal*$getDiscount->value)/100;
                        $total_payble = $cartSubTotal - $discount_amount;
                    }

                    $json['status'] = true;
                    $json['message'] = "Discount Applied";
                    $json['discount_amount'] = number_format($discount_amount,2, '.', '');
                    $json['total_payble'] = number_format($total_payble,2, '.', '');
                    $json['encrypted_discode'] = encrypt($request->discount_code);
                }else{
                    $json['status'] = false;
                    $json['message'] = "Entered discount code is correct for this value!";
                    $json['discount_amount'] = '0.00';
                    $json['total_payble'] = Cart::subtotal(2, '.', '');
                }

            }else{
                $json['status'] = false;
                $json['message'] = "Discount code is invalid";
                $json['discount_amount'] = '0.00';
                $json['total_payble'] = Cart::subtotal(2, '.', '');
            }

            echo json_encode($json);
        }
    }

    public function getShippingCharges(Request $request){
        if($request->ajax()){
            $getTotalWeightCharge = ShippingCharge::getShippingCharge();
            if(!empty($getTotalWeightCharge)){
                $json['status'] = true;
                $json['ShippingCharge'] = $getTotalWeightCharge;
            }else{
                $json['status'] = false;
                $json['ShippingCharge'] = '0.00';
            }
            echo json_encode($json);
        }
    }

    // public function place_order(Request $request){
    //     $validate = 0;
    //     $message = '';

    //     if(!empty(auth()->check())){
    //         $user = auth()->user();
    //         $validate = 1;
    //     }

    //     if(!empty($validate)){
    //         $data = $request->all();

    //         $total_payble = Cart::priceTotal(2, '.', '');
            
    //         $userAddress = UserAddress::whereId(@$data['shipping_charge_id'])->first();
    //         if(empty($userAddress)){
    //             return back()->with('error', 'Selected Shipping Address is incorrect');
    //         }

    //         if(!empty($request->discount_code)){
    //             $getDiscount = Discount::checkDiscount($request->discount_code);
    //             if(!empty($getDiscount)){
    //                 if($getDiscount->type=="Amount"){
    //                     $discount_amount = $getDiscount->value;
    //                     $total_payble = $total_payble - $getDiscount->value;
    //                 }else{
    //                     $discount_amount = ($total_payble*$getDiscount->value)/100;
    //                     $total_payble = $total_payble - $discount_amount;
    //                 }
    //             }
    //         }
    //         if($data['payment_term'] == 'COD')
    //         {
    //             $chargeAmount = 90;
    //             $total_payble = $chargeAmount+$total_payble;            
    //         }
    //         $getTotalWeightCharge = ShippingCharge::getShippingCharge();
    //         $total_amount = $total_payble + $getTotalWeightCharge;
    //         $total_amount = number_format($total_amount,2, '.', '');

    //         if($total_amount<0){
    //             $json['status'] = false;
    //             $json['message'] = "Whoops! Something went wrong";
    //             echo json_encode($json);
    //         }

    //         $order = new Order;
    //         if(!empty($user)){
    //             $order->user_id = trim($user->id);
    //             $order->shipping_charge_id = $userAddress->id ?? 0;
    //             $order->name = $user->name;
    //             $order->mobile = $user->mobile;
    //             $order->email = $user->email;
    //             $order->country = $user->country->name??'';
    //             $order->state = $user->state->name??'';
    //             $order->city = $user->city->name??'';
    //             $order->zipcode = $user->zipcode??'';

    //             if(!empty($user->pincode_id)){
    //                 $order->pincode_id = $pincode->id??0;
    //             }
    //         }

    //         $order->uuid = str()->uuid()->toString();
    //         $order->booking_address =  $userAddress->address ?? ''. ' ' .$userAddress->state->name ?? ''. '-' .$userAddress->zipcode ?? '';
    //         $order->note =  $data['note']??null;
    //         $order->discount_code =  $data['discount_code']??null;
    //         $order->discount_amount =  $discount_amount??0;
    //         $order->shipping_amount =  $data['shipping_amount']??0;
    //         $order->total_amount =  $total_amount??0;
    //         $order->payment_term =  $data['payment_term']??null;
    //         $order->save();

    //         foreach(Cart::content() as $key => $item){
    //             OrderItem::updateOrCreate( 
    //                 [
    //                     'order_id' => $order->id,
    //                     'cart_id' => $item->rowId,
    //                 ],
    //                 [
    //                     'order_id' => $order->id,
    //                     'product_id' => $item->id,
    //                     'product_code' => $item->options->product_code,
    //                     'cart_id' => $item->rowId,
    //                     'product_color' => $item->options->color,
    //                     'product_size' => $item->options->size,
    //                     'price' => $item->price,
    //                     'product_lbh_weight_gm' => $item->weight??0,
    //                     'total_qty' => $item->qty,
    //                     'total_amount' => round($item->price*$item->qty,2),
    //                 ]
    //             );

    //         }
    //         $json['status'] = true;
    //         $json['message'] = "Order Success";
    //         $json['redirect'] = url('checkout/payment?order_id='.base64_encode($order->id));
    //     }else{
    //         $json['status'] = false;
    //         $json['message'] = "Whoops! Something went wrong";
    //     }

    //     echo json_encode($json);
    // }

public function place_order(Request $request){
    $validate = 0;
    $message = '';

    if(!empty(auth()->check())){
        $user = auth()->user();
        $validate = 1;
    }

    if(!empty($validate)){
        $data = $request->all();

        $total_payble = Cart::priceTotal(2, '.', '');
        
        $userAddress = UserAddress::whereId(@$data['shipping_charge_id'])->first();
        if(empty($userAddress)){
            return back()->with('error', 'Selected Shipping Address is incorrect');
        }

        // Calculate shipping charge based on payment method and subtotal
        $subtotal = floatval(Cart::subtotal(2, '.', ''));
        $shippingCharge = 0;
        
        // Apply shipping charge only for Online Payment when subtotal < 500
        if ($data['payment_term'] == 'Prepaid' && $subtotal < 500) {
            $shippingCharge = 89;
        }
        
        // Apply discount if any
        $discount_amount = 0;
        if(!empty($request->discount_code)){
            $getDiscount = Discount::checkDiscount($request->discount_code);
            if(!empty($getDiscount)){
                if($getDiscount->type=="Amount"){
                    $discount_amount = $getDiscount->value;
                    $total_payble = $total_payble - $getDiscount->value;
                }else{
                    $discount_amount = ($total_payble*$getDiscount->value)/100;
                    $total_payble = $total_payble - $discount_amount;
                }
            }
        }
        
        // Apply COD charge if COD payment
        if($data['payment_term'] == 'COD')
        {
            $chargeAmount = 90;
            $total_payble = $chargeAmount + $total_payble;            
        }
        
        // Add shipping charge to total
        $total_payble = $total_payble + $shippingCharge;
        
        $getTotalWeightCharge = ShippingCharge::getShippingCharge();
        $total_amount = $total_payble + $getTotalWeightCharge;
        $total_amount = number_format($total_amount, 2, '.', '');

        if($total_amount < 0){
            $json['status'] = false;
            $json['message'] = "Whoops! Something went wrong";
            echo json_encode($json);
        }

        $order = new Order;
        if(!empty($user)){
            $order->user_id = trim($user->id);
            $order->shipping_charge_id = $userAddress->id ?? 0;
            $order->name = $user->name;
            $order->mobile = $user->mobile;
            $order->email = $user->email;
            $order->country = $user->country->name??'';
            $order->state = $user->state->name??'';
            $order->city = $user->city->name??'';
            $order->zipcode = $user->zipcode??'';

            if(!empty($user->pincode_id)){
                $order->pincode_id = $user->pincode_id;
            }
        }

        $order->uuid = str()->uuid()->toString();
        $order->booking_address =  $userAddress->address ?? ''. ' ' .$userAddress->state->name ?? ''. '-' .$userAddress->zipcode ?? '';
        $order->note =  $data['note']??null;
        $order->discount_code =  $data['discount_code']??null;
        $order->discount_amount =  $discount_amount??0;
        $order->shipping_amount =  $shippingCharge; // Use the calculated shipping charge
        $order->total_amount =  $total_amount??0;
        $order->payment_term =  $data['payment_term']??null;
        $order->save();

        foreach(Cart::content() as $key => $item){
            OrderItem::updateOrCreate( 
                [
                    'order_id' => $order->id,
                    'cart_id' => $item->rowId,
                ],
                [
                    'order_id' => $order->id,
                    'product_id' => $item->id,
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
        $json['status'] = true;
        $json['message'] = "Order Success";
        $json['redirect'] = url('checkout/payment?order_id='.base64_encode($order->id));
    }else{
        $json['status'] = false;
        $json['message'] = "Whoops! Something went wrong";
    }

    echo json_encode($json);
}


/*RAZORPAY_KEY=rzp_live_0Y1iHty0afVxQI 
RAZORPAY_SECRET=1hyBeHX7NLLaUtgQKhQNDdxe*/
    public function checkout_payment(Request $request){
        if(!empty(Cart::priceTotal(2, '.', '')) && !empty($request->order_id)){

            $order_id = base64_decode($request->order_id);
            $getOrder = Order::getSingleOrder($order_id);

            if(!empty($getOrder)){

                if($getOrder->payment_term == "COD"){
                    $getOrder->is_payment = "Complete";
                    $getOrder->save();

                    $this->create_order_log_status($getOrder->id, "Pending");

                    Mail::to($getOrder->email)->send(new OrderInvoiceMail($getOrder));

                    Cart::destroy();
                    $product = Product::whereIn('sku_code', $getOrder->order_items->pluck('product_code')->toArray())
                    ->orWhereIn('full_turn_code', $getOrder->order_items->pluck('product_code')->toArray())
                    ->first();  
                    $templateId = '67ab4b8ed6fc05376176c132';
                    $params = [
                        'mobiles' => '91'.$getOrder->mobile,
                        'orderid' => 'RNOD'.$getOrder->id,
                        'product' => (string)$product->name.'....',
                    ];
                    SendSMS($templateId,$params);

                    return redirect(route('order_placed_success',['orderAmount' => $getOrder->total_amount, 'transactionId' => $getOrder->id]))->with('success', 'Order successfully placed, Order is : '.'RNOD'.$getOrder->id. ' Thank you!');

                }elseif($getOrder->payment_term == "Prepaid"){

                    $client = new Client();
                    razorpay_post_order($getOrder->id);
                    $result = razorpay_payment_link_create($getOrder->id);

                    try{ 
                        /*store payment transaction detail in our database */
                        Payment::updateOrCreate(
                            [
                                'payment_id' => $result->reference_id,
                            ],
                            [
                                'payment_id' => $result->reference_id,
                                'pay_link_id' => $result->id,
                                'short_url' => $result->short_url,
                                'order_id' => $getOrder->id,
                                'name' => $getOrder['name'],
                                'mobile' => $getOrder['mobile'],
                                'email' => $getOrder['email'],
                                'state' => $getOrder['state'],
                                'city' => $getOrder['city'],
                                'zipcode' => $getOrder['zipcode'],
                                'payment_gateway' => "Razorypay",
                                'payment_key' => env('RAZORPAY_KEY'),
                                'payment_secret_key' => env('RAZORPAY_SECRET'),
                                'status' => "Created",
                                'payment_data' => "",
                                'amount' => $getOrder->total_amount,
                            ],
                        );
                        /*end payment*/

                        $getOrder->pay_link_id = $result->id;
                        $getOrder->save();

                        //return view('users.websites.payments.razorpay_success', compact('result','getOrder'));
                        header('Location: '.$result->short_url);
                        exit();
                    }catch(\Exception $e){
                        return back()->with('error', 'Whoops! Something went wrong -'.$e->getMessage());
                    }
                }

            }else{
                abort(404);
            }   

        }else{
            abort(404);
        }
    }


    public function razorypay_success_payment(Request $request){
        if(!empty($request->razorpay_payment_id) && !empty($request->razorpay_payment_link_status) && $request->razorpay_payment_link_status=="paid"){
            $getSingleOrderUuid = Order::getSingleOrderUuid($request->razorpay_payment_link_reference_id);

            if(!empty($getSingleOrderUuid)){

                $getSingleOrderUuid->is_payment = 1;
                $getSingleOrderUuid->payment_data = json_encode($request->all());
                $getSingleOrderUuid->payment_key = $request->razorpay_payment_id;
                $getSingleOrderUuid->save();

                $this->create_order_log_status($getSingleOrderUuid->id, "Pending");

                $payment = Payment::getSinglePaymentPayId($request->razorpay_payment_link_reference_id);

                if(!empty($payment)){
                    $payment->status = $request->razorpay_payment_link_status;
                    $payment->payment_data = json_encode($request->all());
                    $payment->save();
                }

                Mail::to($getSingleOrderUuid->email)->cc('ecommerce@rnvalves.com')->send(new OrderInvoiceMail($getSingleOrderUuid));
                $templateId = '67ab4b8ed6fc05376176c132';
                Cart::destroy();
                $product = Product::whereIn('sku_code', $getSingleOrderUuid->order_items->pluck('product_code')->toArray())
                ->orWhereIn('full_turn_code', $getSingleOrderUuid->order_items->pluck('product_code')->toArray())
                ->first();  
                $params = [
                    'mobiles' => '91'.$getSingleOrderUuid->mobile,
                    'orderid' => 'RNOD'.$getSingleOrderUuid->id,
                    'product' => (string)$product->name.'....',
                ];
                SendSMS($templateId,$params);
                return redirect(route('order_placed_success',['orderAmount' => $getSingleOrderUuid->total_amount, 'transactionId' => $getSingleOrderUuid->id]))->with('success', 'Order successfully placed, Order is : RNOD'.$getSingleOrderUuid->id. ' Thank you!');
            }else{
               abort(404); 
            }

        }else{
            abort(404);
        }
    }

    public function order_placed_success(){
        return view('users.websites.payments.order_placed');
    }


    public function direct_payment_razorypay(Request $request){
        $request->validate([
            'name' => ['required','string','max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:100'],
            'zipcode' => ['required','exists:pincodes,code'],
            'mobile' => ['required','string','digits:10'],
            'g-recaptcha-response' => ['required', new GoogleReCaptcha],
            'amount' => ['required','numeric','min:100'],
        ]);

        try{
            $data = $request->only('name','email','zipcode','mobile','amount');
            $client = new Client();
            $key = str()->uuid()->toString();
            $payment_link_response = $client->post('https://api.razorpay.com/v1/payment_links/', [
                'headers' => [
                    'Content-type' => 'application/json'
                ],
                'auth' => [env('RAZORPAY_KEY'), env('RAZORPAY_SECRET')],
                    'json' => [
                    'amount' => floatval($data['amount'])*100,
                    'currency' => 'INR',
                    'accept_partial' => false,
                    'first_min_partial_amount' => floatval($data['amount'])*100,
                    'reference_id' => $key,
                    'description' => "Direct-Payment",
                    'customer' => [
                        'name' => trim($data['name']),
                        'contact' => $data['mobile'],
                        'email' => trim($data['email']),
                    ],
                    'notify' => [
                        'sms' => true,
                        'email' => true,
                    ],
                    'reminder_enable' => true,
                        'notes' => [
                            'policy_name' => "RN Valves & Faucets",
                        ],
                        'callback_url' => url('razorypay/success-direct-payment'),
                        'callback_method' => 'get'
                    ]
                ]);

            $result = json_decode($payment_link_response->getBody());

            $pincode = Pincode::where('code', $data['zipcode'])->first();
            if(!empty($pincode)){
                /*store payment transaction detail in our database */
                Payment::updateOrCreate(
                    [
                        'payment_id' => $result->reference_id,
                    ],
                    [
                        'payment_id' => $result->reference_id,
                        'pay_link_id' => $result->id,
                        'short_url' => $result->short_url,
                        'name' => $data['name'],
                        'mobile' => $data['mobile'],
                        'email' => $data['email'],
                        'state' => $pincode['state']->name,
                        'city' => $pincode['city']->name,
                        'zipcode' => $data['zipcode'],
                        'payment_gateway' => "Razorypay",
                        'payment_key' => env('RAZORPAY_KEY'),
                        'payment_secret_key' => env('RAZORPAY_SECRET'),
                        'status' => "Created",
                        'payment_data' => "",
                        'amount' => $data['amount'],
                    ],
                );
                /*end payment*/
            }else{
                abort(404);
            }

            header('Location: '.$result->short_url);
            exit();
        }catch(\Exception $e){
            abort(404);
        }
    }

    public function razorpay_direct_success_payment(Request $request){
        if(!empty($request->razorpay_payment_id) && !empty($request->razorpay_payment_link_status) && $request->razorpay_payment_link_status=="paid"){
            
            $payment = Payment::getSinglePaymentPayId($request->razorpay_payment_link_reference_id);

            if(!empty($payment)){
                $payment->status = $request->razorpay_payment_link_status;
                $payment->payment_data = json_encode($request->all());
                $payment->save();
            }

            Mail::to($payment->email)->send(new DirectPaymentMail($payment));

            return redirect(route('order_placed_success'))->with('success', 'Your Payment has been confirmed successfully, Thank you!');
        }
    }

}
