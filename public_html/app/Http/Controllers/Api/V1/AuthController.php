<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\Api\V1\ApiBaseController as BaseController;
use Auth;
use App\Models\User;
use App\Http\Resources\UserResource;
use Validator;

class AuthController extends BaseController
{
    public function __construct()
    {
        $this->middleware('client');
    }   
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => ['string','email','string','max:255'],
            'password' => ['required'],
        ]);
     
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        try{
            $data = $request->only('email','password');
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('User')->accessToken; 
                $success['user'] =  new UserResource($user);
       
                return $this->sendResponse($success, 'User login successfully.');
            } else{ 
                return $this->sendError('Unauthorised.');
            } 
        }catch(\Exception $e){
            return sendError($e->getMessage());
        }
    }
}