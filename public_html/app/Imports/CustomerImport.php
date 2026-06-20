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
    Pincode,
    ReportUser
};
use Hash;
use App\Traits\DefaultTrait;

class CustomerImport implements 
    ToCollection,
    WithValidation,
    WithHeadingRow,
    WithChunkReading,
    WithBatchInserts,
    SkipsOnError
{
use DefaultTrait;
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
            $user = User::where('mobile',$row['mobile'])->first();
            if(empty($user)){
                $uuid = str()->uuid()->toString();
                $created_by = auth()->user()->name;
            }else{
                $uuid = $user->uuid;
                $created_by = $user->created_by;
            }
            $reporting_ids = explode(",", $row['reporting_ids']);
            if(!empty($pincode)){
                $user = User::updateOrCreate(
                    [
                        'mobile' => $row['mobile'],
                    ],
                    [
                        'name' => $row['name'],
                        'uuid' => $uuid,
                        'mobile' => $row['mobile'],
                        'zipcode' => $row['zipcode'],
                        'pincode_id' => $pincode->id,
                        'city_id' => $pincode->city_id,
                        'state_id' => $pincode->state_id,
                        'country_id' => $pincode->country_id,
                        'email' => $row['email'],
                        'address' => $row['address'],
                        'user_code' => $row['user_code'],
                        'password' => Hash::make($row['mobile']),
                        'user_type' => "Customer",
                        'created_by' => $created_by,
                    ],
                );
                $this->assigningReportUsers($reporting_ids, $user->id, $user->user_type);
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
            'name' => ['required','max:55','string'],
            'mobile' => ['required','digits:10'],
            'zipcode' => ['required','exists:pincodes,code'],
            'email' => ['required','max:100','string','email'],
            'address' => ['required','string','max:255'],
            'user_code' => ['required','string','max:255'],
            'reporting_ids' => ['required'],

            // Above is alias for as it always validates in batches
            '*.name' => ['required','max:55','string'],
            '*.mobile' => ['required','digits:10'],
            '*.zipcode' => ['required','exists:pincodes,code'],
            '*.email' => ['required','max:100','string','email'],
            '*.address' => ['required','string','max:255'],
            '*.user_code' => ['required','string','max:255'],
            '*.reporting_ids' => ['required'],
        ];
    }
}
