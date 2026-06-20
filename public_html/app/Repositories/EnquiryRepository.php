<?php

namespace App\Repositories;
use App\Repositories\Interfaces\EnquiryInterface;
use App\Models\{
	Enquiry,
	Pincode
};
use Auth;

class EnquiryRepository implements EnquiryInterface {

	public function store($data){
		$pincode = Pincode::where('code',$data['zipcode'])->first();
		$enquiry = Enquiry::where('mobile',$data['mobile'])->first();
		if(empty($enquiry)){
			$uuid = str()->uuid()->toString();
			if(Auth::check()){
                $data['created_by'] = auth()->user()->name;
            }else{
                $data['created_by'] = $data['name'].','.$data['mobile'];
            }
		}else{
			$uuid = $enquiry->uuid;
			$data['created_by'] = $enquiry->created_by;
		}
		return Enquiry::updateOrCreate(
			[
				'mobile' => $data['mobile'],
			],
			[
				'name' => $data['name'],
				'uuid' => $uuid,
				'mobile' => $data['mobile'],
				'ip_address' => $data['ip_address']??null,
				'company_name' => $data['company_name'],
				'zipcode' => $data['zipcode'],
				'pincode_id' => $pincode->id,
				'city_id' => $pincode->city_id,
				'state_id' => $pincode->state_id,
				'country_id' => $pincode->country_id,
				'email' => $data['email']??null,
				'enquiry_type' => $data['enquiry_type'],
				'scource_type' => $data['scource_type'],
				'address' => $data['address']??null,
				'purpose' => $data['purpose'],
				'page_url' => $data['page_url']??null,
				'published_at' => $data['published_at']??now(),
				'salesmen_id' => $data['salesmen_id']??1,
				'created_by' => $data['created_by'],
			],
		);
	}

	public function update($enquiryId, $data){
		//
	}
}