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

use App\Models\{
    Pincode,
    City,
    State,
    Country
};

class CityImport implements
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
        foreach ($rows as $row) 
        {
            City::updateOrCreate(
                [
                    'code' => $row['code'],
                ],
                [
                    'country_id' => $row['country_id'],
                    'state_id' => $row['state_id'],
                    'code' => $row['code'],
                    'name' => $row['name'],
                ]
            );
        }
    }

    public function chunkSize(): int
    {
        return 5000;
    }

    public function batchSize(): int
    {
        return 5000;
    }

    public function rules(): array
    {
        return [
            'country_id' => ['required','exists:countries,id'],
            'state_id' => ['required','exists:states,id'],
            'name' => ['required'],
            'code' => ['required'],

             // Above is alias for as it always validates in batches
             '*.country_id' => ['required','exists:countries,id'],
             '*.state_id' => ['required','exists:states,id'],
            '*.name' => ['required'],
            '*.code' => ['required'],
        ];
    }
}
