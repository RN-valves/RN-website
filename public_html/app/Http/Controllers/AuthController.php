<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    User,
    UserAddress,
    Order,
    OrderLog,
    OrderCancelLog,
    Pincode
};
use Illuminate\View\View;
use Mail;
use App\Mail\OrderStatusMail;
use GuzzleHttp\Client;
use Illuminate\Validation\Rule;
use App\Mail\RegisterMail;

class AuthController extends Controller
{
    public function activate_email($id){
        $id = base64_decode($id);
        $user = User::getSingleUser($id);
        $user->email_verified_at = now();
        $user->save();
        return redirect(url('/'));
    }

    public function addressesUpdate(Request $request): View
    {
        try{
            return view('profile.address', [
                'addressTypes' => UserAddress::AddressTypes(),
                'user' => $request->user(),
            ]);
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function customer_address_edit(Request $request, UserAddress $userAddress){
        try{
            return view('profile.address', [
                'userAddress' => $userAddress,
                'addressTypes' => UserAddress::AddressTypes(),
                'user' => $request->user(),
            ]);
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
    public function addressStore(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:55'],
            'mobile' => ['required','numeric','digits:10'],
            'zipcode' => ['required','exists:pincodes,code'],
            'address' => ['required','max:255'],
            'user_id' => ['required','exists:users,id'],
            'type' => ['required',Rule::in(['Home','Office','Other'])],
        ]);
        $data = $request->only('name','mobile','zipcode','address','user_id','type');
        $pincode = Pincode::where('code',$data['zipcode'])->first();
        if(empty($pincode)){
            return back()->with('error', 'Pincode not match our records');
        }
        $user = User::findOrFail($data['user_id']);
        $userAddress = UserAddress::where('user_id',$user->id)->count();
        if($userAddress == 0){
            $user->name = $data['name'];
            $user->email = $request->email;
            $user->zipcode = $data['zipcode'];
            $user->pincode_id = $pincode->id;
            $user->city_id = $pincode->city_id;
            $user->state_id = $pincode->state_id;
            $user->country_id = $pincode->country_id;
            $user->address = $data['address'];
            $user->save();
            Mail::to($user->email)->send(new RegisterMail($user));
        }
        if(empty($user)){
            return back()->with('error', 'selected user/customer is invalid');
        }
        try{
            UserAddress::updateOrCreate(
                [
                    'mobile' => $data['mobile'],
                ],
                [
                    'user_id' => $data['user_id'],
                    'mobile' => $data['mobile'],
                    'name' => $data['name'],
                    'city_id' => $pincode->city_id,
                    'state_id' => $pincode->state_id,
                    'country_id' => $pincode->country_id,
                    'name' => $data['name'],
                    'zipcode' => $data['zipcode'],
                    'address' => $data['address'],
                    'type' => $data['type'],
                ],
            );
            return redirect()->back()->with('success','Shipping Address has been updated successfully, Thank You!!');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function customer_order_list(){
        return view('profile.orders');
    }

    public function customer_order_detail(Order $order){
        return view('profile.order_detail', compact('order'));
    }

    public function cancel_order(Request $request, Order $order){
        if($request->isMethod("post")){
            $request->validate([
                'selected_reason' => ['required','exists:order_cancels,name'],
                'cancel_reason_text' => ['required','string','max:255'],
            ]);
            try{
                $data = $request->only('selected_reason','cancel_reason_text');
                $getSingleOrder =  Order::getSingleOrder($order->id);
                if(!empty($getSingleOrder)){

                    $getSingleOrder->status = "Cancelled";
                    $getSingleOrder->save();

                    OrderLog::create(
                        [
                            'order_id' => $getSingleOrder->id,
                            'user_id' => auth()->user()->id,
                            'user_name' => auth()->user()->name,
                            'change_value' => "Cancelled",
                            'change_type' => "status",
                        ],
                    );

                    OrderCancelLog::updateOrCreate(
                        [
                            'order_id' => $getSingleOrder->id,
                        ],
                        [
                            'order_id' => $getSingleOrder->id,
                            'user_id' => auth()->user()->id,
                            'user_name' => auth()->user()->name,
                            'selected_reason' => $data['selected_reason'],
                            'cancel_reason_text' => $data['cancel_reason_text'],
                        ],
                    );

                    if(!empty($getSingleOrder->pay_link_id)){
                        $result = razorpay_link_cancel($getSingleOrder->pay_link_id);
                        $result = json_decode($result->getBody());

                        $payment = Payment::getPaymentUrl($getSingleOrder->pay_link_id);
                        $payment->status = $result->status;
                        $payment->save();
                    }
                     
                    Mail::to($getSingleOrder->email)->send(new OrderStatusMail($getSingleOrder));
                    order_cancel_shipway($getSingleOrder);
                    return back()->with('success', 'Order has been cancelled successfully');
                }
            }catch(\Exception $e){
                return back()->with('error', $e->getMessage());
            }
        }
    }
}
