<?php

namespace App\Livewire;

use App\Models\{
    Discount
};
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class DiscountIndex extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Discount::query()->orderByDesc('id');
    }

    /*public function relationSearch(): array
    {
        return [
            'category' => [
                'name',
            ],
            'content' => [
                'name',
            ],
        ];
    }*/

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('created_at_formatted', fn (Discount $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'))
            ->add('expired_at_formatted', fn (Discount $model) => Carbon::parse($model->expired_at)->timezone('Asia/Kolkata')->format('d M Y'))
            ->add('name')
            ->add('start_value')
            ->add('end_value')
            ->add('type')
            ->add('value')
            ->add('status');
    }

    public function columns(): array
    {
        return [
            Column::action('Id'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),
            Column::make('Expire at', 'expired_at_formatted', 'expired_at')
                ->sortable(),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Start At', 'start_value')
                ->sortable()
                ->searchable(),

            Column::make('End At', 'end_value')
                ->sortable()
                ->searchable(),

            Column::make('Type', 'type')
                ->sortable()
                ->searchable(),

            Column::make('Value', 'value')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            //
        ];
    }

    public function actions(Discount $row): array
    {
        return [
            Button::add('DS'.$row->id)
                ->slot('DS'.$row->id)
                ->class('text-bold')
                ->route('discounts.show', ['discount' => $row])
                ->can(allowed: auth()->check()),
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
