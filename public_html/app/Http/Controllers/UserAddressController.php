<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    UserAddress,
    User,
    Pincode
};
use Illuminate\Foundation\Validation\ValidatesRequests;
use Validator;
use Illuminate\Validation\Rule;

class UserAddressController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:user-address-list'], ['only' => ['index']]);
        $this->middleware(['permission:user-address-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:user-address-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:user-address-delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try{
            $user = User::whereUuid($request->user)->first();
            if(empty($user)){
                return back()->with('error', 'selected user/customer is invalid');
            }
            $addressTypes = UserAddress::AddressTypes();
            return view('admin.users.addresses.index',compact('user','addressTypes'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

    /**
     * Display the specified resource.
     */
    public function show(UserAddress $userAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserAddress $userAddress)
    {
        try{
            $user = User::whereId($userAddress->user_id)->first();
            if(empty($user)){
                return back()->with('error', 'selected user was invalid');
            }
            $addressTypes = UserAddress::AddressTypes();
            return view('admin.users.addresses.index',compact('userAddress','user','addressTypes'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserAddress $userAddress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserAddress $userAddress)
    {
        try{
            if($userAddress->forceDelete()){
                return back()->with('success','Your Shipping Address has been removed successfully!');
            }
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}
