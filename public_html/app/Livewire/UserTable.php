<?php

namespace App\Livewire;

use App\Models\User;
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


final class UserTable extends PowerGridComponent
{
    use WithExport;
    public int $city_id = 0;
    public int $state_id = 0;


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
        //return User::query()->with('city');
        return User::query()
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
            );
    }

    public function relationSearch(): array
    {
        return [
            'city' => [
                'name',
            ],
            'state' => [
                'name',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('created_at_formatted', fn (User $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'))
            ->add('name')
            ->add('mobile')
            ->add('state', fn ($dish) => e($dish->state->name))
            ->add('city', fn ($dish) => e($dish->city->name))
            ->add('zipcode')
            ->add('roles', fn (User $model) => e($model->roles->pluck('name','name')->first()??''))
            ->add('assigned', fn ($model) => e(User::whereIn('id', $model->reporting_users->pluck('reporting_id'))->pluck('name') ))
            ->add('user_type')
            ->add('user_code')
            ->add('status')
            ->add('email_verified_at');
    }

    public function columns(): array
    {
        return [

            Column::action('Action'),

            Column::make('Id', 'id'),

            Column::make('Created at (YYYY-MM-DD)', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            /*LinkColumn::make('Name','name')
                ->title(fn($row) => 'name')
                ->location(fn($row) => route('users.show', $row)),*/

            Column::make('Mobile', 'mobile')
                ->sortable()
                ->searchable(),

            Column::make('State', 'state')
                ->searchable(),

            Column::make('City', 'city')
                ->searchable(),

            Column::make('Zipcode', 'zipcode')
                ->sortable()
                ->searchable(),

            Column::make('Role', 'roles')
                ->sortable()
                ->searchable(),

            Column::make('AssignedTo', 'assigned')
                ->sortable()
                ->searchable(),

            Column::make('User code', 'user_code')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('Status')
                ->field('status')
                ->sortable(),

            Column::add()
                ->title('Email Verified')
                ->field('email_verified_at')
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            // Filter::inputText('name', 'name')
            //  ->operators(['contains', 'is', 'is_not']),
            Filter::inputText('name')->placeholder('Name'),
            // Filter::inputText('user_type')->placeholder('Type'),
            Filter::inputText('created_at')->placeholder('YYYY-MM-DD (Created At)'),
            Filter::inputText('mobile')->placeholder('Mobile'),
            Filter::inputText('zipcode')->placeholder('Zipcode'),
            Filter::inputText('email')->placeholder('Email'),
            Filter::inputText('user_code')->placeholder('UserCode'),
            Filter::inputText('city')
                ->filterRelation('city', 'name'),
            Filter::inputText('state')
                ->filterRelation('state', 'name'),

            Filter::select('status')
                ->dataSource(User::select('status')->groupBy('status')->get())
                ->optionLabel('status')
                ->optionValue('status'),

            // Filter::boolean('user_type', 'user_type')
            //     ->label('Normal', 'Normal'),
      
            // Filter::datepicker('date_of_join'),
        ];
    }


    public function actions(User $row): array
    {
        return [
            Button::add('View')
                ->slot('View')
                ->class('btn btn-primary btn-sm')
                ->route('users.show', ['user' => $row])
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
