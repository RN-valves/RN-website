<?php

namespace App\Livewire;

use App\Models\Order;
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


final class OrderIndex extends PowerGridComponent
{
    use WithExport;

    // public array $name;

    // public bool $showErrorBag = true;
    public int $user_id = 0;

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
        //return Order::query()->orderByDesc('id');
        return Order::query()
            ->latest()
            ->when(
                $this->user_id,
                fn ($builder) => $builder->whereHas(
                    'user',
                    fn ($builder) => $builder->where('user_id', $this->user_id)
                )
                ->with(['user'])
            );
    }

    public function relationSearch(): array
    {
        return [
            'user' => [
                'profession',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('created_at_formatted', fn (Order $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'))
            ->add('name')
            ->add('mobile')
            ->add('state')
            ->add('shipping_amount')
            ->add('total_amount')
            ->add('is_payment', fn (Order $model) => $model->is_payment ? 'Yes' : 'No'/*. ' ('. $model->pay_link_id??''.')'*/)
            ->add('discount_code')
            ->add('discount_amount')
            ->add('status')
            ->add('payment_term')
            ->add('payment_key')
            ->add('user_type', fn (Order $model) => $model->user->profession??'')
            ->add('uuid')
            ->add('city')
            ->add('zipcode')
            ->add('email')
            ->add('deleted_at_formatted', fn (Order $model) => Carbon::parse($model->deleted_at??null)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'));
    }

    public function columns(): array
    {
        return [

            Column::action('Action'),

            Column::make('Created at (YYYY-MM-DD)', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Mobile', 'mobile')
                ->sortable()
                ->searchable(),

            Column::make('State', 'state')
                ->searchable(),

        

            Column::make('Shipping', 'shipping_amount')
                ->sortable()
                ->searchable(),

            Column::make('Total Amount', 'total_amount')
                ->sortable()
                ->searchable(),
            Column::make('Is Payment?', 'is_payment')
                ->sortable()
                ->searchable(),

            Column::make('Discount Code', 'discount_code')
                ->sortable()
                ->searchable(),

            Column::make('Discount', 'discount_amount')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('Status')
                ->field('status')
                ->sortable(),

            Column::make('Payment Term', 'payment_term')
                ->sortable()
                ->searchable(),     

            Column::make('Payment Key', 'payment_key')
                ->sortable()
                ->searchable(),

            Column::make('User Type', 'user_type')
                ->sortable()
                ->searchable(),

            Column::make('Uid', 'uuid')
                ->sortable()
                ->searchable(),
            Column::make('City', 'city')
                ->searchable(),

            Column::make('Zipcode', 'zipcode')
                ->sortable()
                ->searchable(),
            Column::make('Email', 'email')
                ->sortable()
                ->sortable(),

            Column::make('Deleted at (YYYY-MM-DD)', 'deleted_at_formatted', 'deleted_at')
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            // Filter::inputText('name', 'name')
            //  ->operators(['contains', 'is', 'is_not']),
            Filter::inputText('name')->placeholder('Name'),
            Filter::inputText('created_at')->placeholder('YYYY-MM-DD (Created At)'),
            Filter::inputText('mobile')->placeholder('Mobile'),
            Filter::inputText('zipcode')->placeholder('Zipcode'),
            Filter::inputText('state')->placeholder('State'),
            Filter::inputText('city')->placeholder('city'),

            Filter::select('status')
                ->dataSource(Order::select('status')->groupBy('status')->get())
                ->optionLabel('status')
                ->optionValue('status'),

            Filter::inputText('user_type')
                ->filterRelation('user', 'profession'),

            /*Filter::boolean('is_payment', 'Is Payment?')
                ->label('Yes', 'No'),*/
        ];
    }

    public function actions(Order $row): array
    {
        return [
            Button::add('RNOD'.$row->id)
                ->slot('RNOD'.$row->id)
                ->class('text-bold')
                ->route('orders.show', ['order' => $row])
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
