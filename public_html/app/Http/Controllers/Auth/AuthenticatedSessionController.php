<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Mail\RegisterMail;
use Mail;
use GuzzleHttp\Client;
use App\Models\User;
use App\Traits\DefaultTrait;
use Spatie\Permission\Models\Role;
use Hash;

class AuthenticatedSessionController extends Controller
{
    use DefaultTrait;
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        /*if(empty(Auth::user()->email_verified_at)){
            $request->user()->sendEmailVerificationNotification();
            return back()->with('status', 'Your Account Email not Verified! Please check your inbox and verify email');
        }*/

        if(Auth::user()->status=="InActive"){
            Auth::logout();
            return back()->with('status', 'Your Account is not Active now, please contact the office/admin!!');
        }

        if(empty(Auth::user()->email_verified_at)){
            if(Auth::user()->user_type === 'Customer'){
                Auth::user()->email_verified_at = now();
                Auth::user()->save();
            } else {
                Mail::to(Auth::user()->email)->send(
                    new RegisterMail(Auth::user())
                );
                Auth::logout();
                return back()->with('status', 'Your Account Email not Verified! Please check your inbox and verify email');
            }
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function SendLoginOtp(Request $request)
    {
        try{
            $authKey = MSG91Key();
            $url = MSG91Url();
            $client = new Client();
            $headers = [
              'content-type' => 'application/json'
            ];
            $body = json_encode([
                "otp_expiry" => '5',   
                "template_id" => '67a9e391d6fc054dce7b0594',   
                "mobile" => (int)'91'.$request->mobile_number,   
                "authkey" => (string) $authKey,   
                "realTimeResponse" => '1',   
            ], JSON_UNESCAPED_SLASHES);
            $response = $client->post($url.'otp', [
                'headers' => $headers,
                'body' => $body
            ]);
            $responseBody = $response->getBody()->getContents();
            $decodeData = json_decode($responseBody,true);
            if($decodeData['type'] == 'success'){
               $success = true;
               $message = 'OTP sent successfully!';
            }else{
                $success = false;
                $message = 'Something went wrong!';
            }
            return response()->json([
                'success' => $success,
                'message' => $message,
                'data' => $responseBody,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
       
    }
    public function VerifyLoginOtp(Request $request)
    {
        try{
            $authKey = MSG91Key();
            $url = MSG91Url();
            $client = new Client();
            $headers = [
              'authkey' => (string)$authKey
            ];
            $response = $client->get($url.'otp/verify', [
                'headers' => $headers,
                'query'   => [
                    'otp' => $request->otp,
                    'mobile' => '91'.$request->mobile_number,
                    ]
            ]);
            $responseBody = $response->getBody()->getContents();
            $decodeData = json_decode($responseBody,true);
            if($decodeData['type'] == 'success'){
               $input = $request->all();
               $input['user_type'] = "Customer";
               $input['created_by'] = "Self";
               $input['reporting_ids'] = [2];
               $input['sales_user_id'] = 2;
               $roles = Role::where('id',3)->first();
       
               $input['user_code'] = $input['user_code']??'RN'.str()->random(10).'-'.User::max('id')+1;
               if($firstUser = User::where('mobile',$input['mobile_number'])->first()){
                   if($firstUser->status == 'InActive'){
                       return response()->json([
                           'success' => false,
                           'message' => 'Your account is not active. Please contact support.',
                       ]);
                   }

                   if(empty($firstUser->email_verified_at)){
                       $firstUser->email_verified_at = now();
                       $firstUser->save();
                   }

                   Auth::login($firstUser);
                   $request->session()->regenerate();

                   return response()->json([
                    'success' => true,
                    'message' => 'Login successfully!',
                    'redirect' => url()->previous(),
                    'data' => '',
                ]);
               }
               $user = User::updateOrCreate(
                [
                    'mobile' => $input['mobile_number'],
                ],
                [
                    'mobile' => $input['mobile_number'],
                    'user_code' => $input['user_code'],
                    'password' => Hash::make($input['mobile_number']),
                    'local_password' => $input['mobile_number'],
                    'user_type' => $input['user_type'],
                    'uuid' => str()->uuid()->toString(),
                    'status' => 'Active',
                    'email_verified_at' => now(),
                    'created_by' => $input['created_by'],
                    'gst_number' => $input['gst_number']??null,
                    'profession' => $input['profession']??"Consumer",
                    'sales_user_id' => $input['sales_user_id']??null,
                ]
               );
               $this->assigningReportUsers($input['reporting_ids'], $user->id, $user->user_type);
               $user->assignRole($roles);
               $success = true;
               $message = 'Login successfully!';
               $redirect = url()->previous();
               Auth::login($user);
               $request->session()->regenerate();
            }else{
                $success = false;
                $message = $decodeData['message'];
                $redirect = "";
            }
            return response()->json([
                'success' => $success,
                'message' => $message,
                'redirect' => $redirect,
                'data' => $responseBody,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
       
    }

    public function ResendLoginOtp(Request $request)
    {

        try{
            $authKey = MSG91Key();
            $url = MSG91Url();
            $client = new Client();
            $headers = [
              'authkey' => (string)$authKey
            ];
            $response = $client->get($url.'otp/retry', [
                'query'   => [
                    'authkey' => (string)$authKey,
                    'retrytype' => 'text',
                    'mobile' => '91'.$request->mobile_number,
                    ]
            ]);
            $responseBody = $response->getBody()->getContents();
            $decodeData = json_decode($responseBody,true);
            if($decodeData['type'] == 'success'){
               $success = true;
               $message = 'OTP resend successfully!';
            }else{
                $success = false;
                $message = $decodeData['message'];
            }
            return response()->json([
                'success' => $success,
                'message' => $message,
                'data' => $responseBody,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
       
    }
}
