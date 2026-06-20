<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;


class CustomerExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function query()
    {
        return User::query()->where(['user_type'=>'Customer'])->with(['city','state']);
    }

    public function headings(): array
    {
        return [
            'id',
            'user_type',
            'name',
            'email',
            'mobile',
            'zipcode',
            'country',
            'state',
            'city',
            'address',
            'user_code',
            'created_at',
            'reporting_ids',
            'reporting_users',

        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->user_type,
            $user->name,
            $user->email,
            $user->mobile,
            $user->zipcode,
            $user->country->name,
            $user->state->name,
            $user->city->name,
            $user->address,
            $user->user_code,
            $user->created_at,
            $user->reporting_users->pluck('reporting_id'),
            User::whereIn('id', $user->reporting_users->pluck('reporting_id'))->pluck('name'),
        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'user_type',
            'name',
            'email',
            'mobile',
            'zipcode',
            'address',
            'user_code',
            'created_at',
        ];
    }
}