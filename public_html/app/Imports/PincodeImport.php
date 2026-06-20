<?php

namespace App\Imports;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

use App\Models\{
    Pincode,
    City,
    State,
    Country
};

class PincodeImport implements ToModel,WithHeadingRow,WithChunkReading
{
    use Importable, SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function model(array $row)
    {
        // Validator::make($row->toArray(), [
        //      'country_id' => 'required',
        //  ])->validate();

        return Pincode::updateOrCreate(
            [
                'code' => $row['code'],
            ],
            [
                'country_id' => $row['country_id'],
                'state_id' => $row['state_id'],
                'city_id' => $row['city_id'],
                'code' => $row['code'],
                'name' => $row['name'],
            ],
        );
    }

    public function chunkSize(): int
    {
        return 50000;
    }

    public function batchSize(): int
    {
        return 50000;
    }

    public function rules(): array
    {
        return [
            'country_id' => ['required','exists:countries,id'],
            'state_id' => ['required','exists:states,id'],
            'city_id' => ['required','exists:cities,id'],
            'name' => ['required'],
            'code' => ['required'],

            // Above is alias for as it always validates in batches
            '*.country_id' => ['required','exists:countries,id'],
            '*.state_id' => ['required','exists:states,id'],
            '*.city_id' => ['required','exists:cities,id'],
            '*.name' => ['required'],
            '*.code' => ['required'],
        ];
    }
}
