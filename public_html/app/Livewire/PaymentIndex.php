<?php

namespace App\Livewire;

use App\Models\Payment;
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


final class PaymentIndex extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        //$this->showCheckBox('id');
 
        return [
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
        ];
    }

    public function datasource(): Builder
    {
        return Payment::query()->orderByDesc('id');
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
            ->add('created_at_formatted', fn (Payment $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'))
            ->add('amount')
            ->add('name')
            ->add('mobile')
            ->add('pay_link_id')
            ->add('short_url')
            ->add('status')
            ->add('state')
            ->add('city')
            ->add('zipcode')
            ->add('payment_key')
            ->add('order_id')
            ->add('payment_id');
    }

    public function columns(): array
    {
        return [
            Column::action('Id'),

            Column::make('Created at (YYYY-MM-DD)', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Amount', 'amount')
                ->sortable()
                ->searchable(),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Mobile', 'mobile')
                ->sortable()
                ->searchable(),

            Column::make('Pay Id', 'pay_link_id')
                ->sortable()
                ->searchable(),

            Column::make('Payment URL', 'short_url')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

            Column::make('State', 'state')
                ->searchable(),

            Column::make('City', 'city')
                ->searchable(),

            Column::make('Zipcode', 'zipcode')
                ->sortable()
                ->searchable(),

            Column::make('Payment Key', 'payment_key')
                ->sortable()
                ->searchable(),

            Column::make('Payment Id', 'payment_id')
                ->sortable()
                ->searchable(),

            Column::make('Order Number', 'order_id')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name')->placeholder('Name'),
            Filter::inputText('pay_link_id')->placeholder('Pay Id'),
            Filter::inputText('short_url')->placeholder('Payment URL'),
            Filter::inputText('created_at')->placeholder('YYYY-MM-DD (Created At)'),
            Filter::inputText('mobile')->placeholder('Mobile'),
            Filter::inputText('zipcode')->placeholder('Zipcode'),
            Filter::inputText('state')->placeholder('State'),
            Filter::inputText('city')->placeholder('city'),
            Filter::inputText('payment_key')->placeholder('payment_key'),
            Filter::inputText('payment_id')->placeholder('payment_id'),
            Filter::inputText('order_id')->placeholder('order_id'),
        ];
    }

    public function actions(Payment $row): array
    {
        return [
            Button::add('PY'.$row->id)
                ->slot('PY'.$row->id)
                ->class('text-bold')
                ->route('payments.show', ['payment' => $row])
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
