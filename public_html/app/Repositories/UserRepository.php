<?php

namespace App\Repositories;
use App\Repositories\Interfaces\UserInterface;
use App\Models\{
	User,
	Pincode,
	City,
	State,
    ReportUser,
};
use Hash;
use DB;

use App\Traits\DefaultTrait;
/**
 * 
 */
class UserRepository implements UserInterface
{
    use DefaultTrait;
	public function store($data){
		$pincode = Pincode::where(['code'=>$data['zipcode']])->first();
		$data['user_code'] = $data['user_code']??'RN'.str()->random(10).'-'.User::max('id')+1;

        //$local_password = $data['password'];

        if(empty($data['password'])){
            $data['password'] = Hash::make($data['mobile']);
            $data['local_password'] = $data['mobile'];
        }else{
            $local_password = $data['password'];
            $data['password'] = Hash::make($data['password']);
            $data['local_password'] = $local_password;
        }

        $user = User::updateOrCreate(
            [
                'mobile' => $data['mobile'],
            ],
            [
                'mobile' => $data['mobile'],
                'user_code' => $data['user_code'],
                'password' => $data['password'],
                'local_password' => $data['local_password'],
                'pincode_id' => $pincode->id,
                'city_id' => $pincode->city_id,
                'state_id' => $pincode->state_id,
                'country_id' => $pincode->country_id,
                'user_type' => $data['user_type'],
                'name' => $data['name'],
                'uuid' => str()->uuid()->toString(),
                'email' => $data['email'],
                'zipcode' => $data['zipcode'],
                'address' => $data['address'],
                'status' => $data['status']??'Active',
                'created_by' => $data['created_by'],
                'gst_number' => $data['gst_number']??null,
                'profession' => $data['profession']??"Consumer",
                'sales_user_id' => $data['sales_user_id']??null,
            ]
        );
        $this->assigningReportUsers($data['reporting_ids'], $user->id, $user->user_type);
        return $user;
	}
    

	public function update($userId, $data){
		$pincode = Pincode::where(['code'=>$data['zipcode']])->first();
        $user = User::whereId($userId)->update(
            [
                'pincode_id' => $pincode->id,
                'city_id' => $pincode->city_id,
                'state_id' => $pincode->state_id,
                'country_id' => $pincode->country_id,
                'user_type' => $data['user_type'],
                'name' => $data['name'],
                'zipcode' => $data['zipcode'],
                'address' => $data['address'],
                'status' => $data['status']??'Active',
                'gst_number' => $data['gst_number']??null,
                'profession' => $data['profession']??"Consumer",
                'sales_user_id' => $data['sales_user_id']??null,
            ]
        );
        $user = User::find($userId);
        DB::table('model_has_roles')->where('model_id',$user->id)->delete();
        return $user;
	}
}
