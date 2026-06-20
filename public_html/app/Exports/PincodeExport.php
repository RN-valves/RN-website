<?php

namespace App\Exports;

use App\Models\Pincode;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;


class PincodeExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function query()
    {
        return Pincode::query()->with(['city','state']);
    }

    public function headings(): array
    {
        return [
            '#',
            'State',
            'City',
            'Name',
            'Pincode',
            'Created At'
        ];
    }

    public function map($pincode): array
    {
        return [
            $pincode->id,
            $pincode->state->name,
            $pincode->city->name,
            $pincode->name,
            $pincode->code,
            $pincode->created_at
        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'state',
            'city',
            'name',
            'code',
            'created_at'
        ];
    }
}