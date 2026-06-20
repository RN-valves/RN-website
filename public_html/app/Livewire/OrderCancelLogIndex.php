<?php

namespace App\Livewire;

use App\Models\{
    OrderCancel,
    OrderCancelLog
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
use Livewire\Component;
use PowerComponents\LivewirePowerGrid\Lazy;
use PowerComponents\LivewirePowerGrid\Facades\Rule;


final class OrderCancelLogIndex extends PowerGridComponent
{
    use WithExport;

    // public array $name;

    // public bool $showErrorBag = true;

    public function setUp(): array
    {
        //$this->showCheckBox('id');
 
        return [
            // Exportable::make('export')
            //     ->striped()
            //     ->columnWidth([
            //         2 => 30,
            //     ])
            //     ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Exportable::make('export-users.xls')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
 
            Header::make()
                ->showToggleColumns()
                ->withoutLoading()
                ->showSearchInput(),
 
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),

            // Lazy::make()
            //     ->rowsPerChildren(25),


            // Footer::make()
            //      ->showPerPage(perPage: 10, perPageValues: [0, 50, 100, 500]), 
        ];
    }

    public function datasource(): Builder
    {
        return OrderCancelLog::query()->orderByDesc('id');
        /*return Order::query()
            ->where('user_type','Employee')
            ->whereNotIn('id',[1])
            ->latest()
            ->when(
                $this->city_id,
                fn ($builder) => $builder->whereHas(
                    'city',
                    fn ($builder) => $builder->where('city_id', $this->city_id)
                )
                ->with(['city','state'])
            );*/
    }

    public function relationSearch(): array
    {
        return [
            //
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('created_at_formatted', fn (OrderCancelLog $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'))
            ->add('user_name')
            ->add('order_id')
            ->add('selected_reason')
            ->add('cancel_reason_text');
    }

    public function columns(): array
    {
        return [
            Column::action('Id'),

            Column::make('Created at (YYYY-MM-DD)', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Cancel By', 'user_name')
                ->sortable()
                ->searchable(),

            Column::make('Order Id', 'order_id')
                ->sortable()
                ->searchable(),

            Column::make('Selected Reason', 'selected_reason')
                ->searchable(),

            Column::make('Reason', 'cancel_reason_text')
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            //Filter::inputText('selected_reason')->placeholder('Selected Reason'),
            Filter::inputText('order_id')->placeholder('Order Id'),
            Filter::inputText('user_name')->placeholder('Cancel By'),
            Filter::select('selected_reason')
                ->dataSource(OrderCancel::select('name')->get())
                ->optionLabel('name')
                ->optionValue('name'),
        ];
    }

    public function actions(OrderCancelLog $row): array
    {
        return [
            Button::add('ODCN'.$row->id)
                ->slot('ODCN'.$row->id)
                ->class('text-bold')
                ->route('orders.show', ['order' => $row->order])
                ->can(allowed: auth()->check()),
        ];
    }

    
    // public function actionRules($row): array
    // {
    //    return [
    //         // Hide button edit for ID 1
    //         Rule::button('View')
    //             ->when(fn($row) => $row->id === 1)
    //             ->hide(),
    //     ];
    // }

    // public function rules()
    // {
    //     return [
    //         'name.*' => ['required', 'alpha', 'max:130'],
    //     ];
    // }

    // public function onUpdatedEditable(string|int $id, string $field, string $value): void
    // {
    //     $this->validate(); 
        
    //     User::query()->find($id)->update([
    //         $field => e($value),
    //     ]);
    // }
    
}
