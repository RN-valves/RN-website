<?php

namespace App\Imports;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

use App\Models\{
    User,
    Enquiry,
    Pincode
};

class EnquiryImport implements 
    ToCollection,
    WithValidation,
    WithHeadingRow,
    WithChunkReading,
    WithBatchInserts,
    SkipsOnError
{
use Importable, SkipsErrors;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $pincode = Pincode::where('code',$row['zipcode'])->first();
            $enquiry = Enquiry::where('mobile',$row['mobile'])->first();
            if(empty($enquiry)){
                $uuid = str()->uuid()->toString();
            }else{
                $uuid = $enquiry->uuid;
            }

            if(!empty($pincode)){
                Enquiry::updateOrCreate(
                    [
                        'mobile' => $row['mobile'],
                    ],
                    [
                        'name' => $row['name'],
                        'uuid' => $uuid,
                        'mobile' => $row['mobile'],
                        'ip_address' => '',
                        'company_name' => $row['company_name'],
                        'zipcode' => $row['zipcode'],
                        'pincode_id' => $pincode->id,
                        'city_id' => $pincode->city_id,
                        'state_id' => $pincode->state_id,
                        'country_id' => $pincode->country_id,
                        'email' => $row['email']??null,
                        'enquiry_type' => $row['enquiry_type'],
                        'scource_type' => $row['scource_type'],
                        'address' => $row['address']??null,
                        'purpose' => $row['purpose'],
                        'page_url' => $row['page_url']??null,
                        'published_at' => $row['published_at']??now(),
                        'salesmen_id' => $row['salesmen_id']??1,
                    ],
                );
            }
        }
    }

    public function chunkSize(): int
    {
        return 10000;
    }

    public function batchSize(): int
    {
        return 10000;
    }

    public function rules(): array
    {
        return [
            'salesmen_id' => ['required','exists:users,id'],
            'name' => ['required','max:55','string'],
            'company_name' => ['required','max:55','string'],
            'mobile' => ['required','digits:10'],
            'zipcode' => ['required','exists:pincodes,code'],
            'email' => ['nullable','max:100','string','email'],
            'enquiry_type' => ['required',Rule::in(['Distributor','Retailer','Direct-Dealer','Other'])],
            'scource_type' => ['required',Rule::in(['Facebook','Website','Call','Walk','SMS','Toll-Free','JustDial','Whatsapp','IndiaMart','Reference','Other'])],
            'address' => ['nullable','string','max:255'],
            'purpose' => ['required','string','max:255'],
            'page_url' => ['nullable','string'],
            'published_at' => ['nullable','date'],

            // Above is alias for as it always validates in batches
            '*.salesmen_id' => ['required','exists:users,id'],
            '*.name' => ['required','max:55','string'],
            '*.company_name' => ['required','max:55','string'],
            '*.mobile' => ['required','digits:10'],
            '*.zipcode' => ['required','exists:pincodes,code'],
            '*.email' => ['nullable','max:100','string','email'],
            '*.enquiry_type' => ['required',Rule::in(['Distributor','Retailer','Direct-Dealer','Other'])],
            '*.scource_type' => ['required',Rule::in(['Facebook','Website','Call','Walk','SMS','Toll-Free','JustDial','Whatsapp','IndiaMart','Reference','Other'])],
            '*.address' => ['nullable','string','max:255'],
            '*.purpose' => ['required','string','max:255'],
            '*.page_url' => ['nullable','string'],
            '*.published_at' => ['nullable','date'],
        ];
    }
}
