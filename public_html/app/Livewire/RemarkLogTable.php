<?php

namespace App\Livewire;

use App\Models\{
    RemarkLog,
    Remark
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

final class RemarkLogTable extends PowerGridComponent
{
    use WithExport;
    public int $user_id = 0;

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
        //return RemarkLog::query();
        // if(auth()->user()->hasAnyRole(['Super_Admin','Admin'])){
            return RemarkLog::query()
            ->whereMonth('created_at', now())
            ->whereYear('created_at', now())
            ->latest()
            ->when(
                $this->user_id,
                fn ($builder) => $builder->whereHas(
                    'user',
                    fn ($builder) => $builder->where('user_id', $this->user_id)
                )
                ->with(['user','logable'])
            );
        // }else{
        //     return RemarkLog::query()
        //     ->where(['user_id'=>auth()->user()->id])
        //     ->whereMonth('created_at', now())
        //     ->whereYear('created_at', now())
        //     ->latest()
        //     ->when(
        //         $this->user_id,
        //         fn ($builder) => $builder->whereHas(
        //             'user',
        //             fn ($builder) => $builder->where('user_id', $this->user_id)
        //         )
        //         ->with(['user','logable'])
        //     );
        // } 
    }

    public function relationSearch(): array
    {
        return [
            'user' => [
                'name',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('created_at_formatted', fn (RemarkLog $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'))
            ->add('customer_name')
            ->add('customer_mobile')
            ->add('user_name')
            ->add('remark')
            ->add('message');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),

            Column::make('Created at (YYYY-MM-DD)', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Customer Name', 'customer_name')
                ->sortable()
                ->searchable(),

            Column::make('Customer Mobile', 'customer_mobile')
                ->sortable()
                ->searchable(),

            Column::make('Caller Name', 'user_name')
                ->sortable()
                ->searchable(),

            Column::make('Remark', 'remark')
                ->sortable()
                ->searchable(),

            Column::make('Content', 'message')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('user_name')->placeholder('Caller Name'),
            Filter::inputText('message')->placeholder('Content'),
            Filter::inputText('created_at')->placeholder('YYYY-MM-DD (Created At)'),
            Filter::inputText('customer_name')->placeholder('Customer Name'),
            Filter::inputText('customer_mobile')->placeholder('Customer Mobile'),

            /*Filter::inputText('user_name')
                ->filterRelation('user', 'name'),*/

            Filter::select('remark', 'Remark')
                ->dataSource(Remark::all())
                ->optionLabel('name')
                ->optionValue('name'),
        ];
    }

    /*#[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }*/

    /*public function actions(RemarkLog $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: '.$row->id)
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id])
        ];
    }*/

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
