<?php

namespace App\Livewire;

use App\Models\Career;
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


final class CareerIndex extends PowerGridComponent
{
    use WithExport;

    // public array $name;

    // public bool $showErrorBag = true;

    public function setUp(): array
    {
        //$this->showCheckBox('id');
 
        return [
            Exportable::make('export.xls')
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
        return Career::query()->orderByDesc('id');
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
            ->add('created_at_formatted', fn (Career $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'))
            ->add('title')
            ->add('designation')
            ->add('state')
            ->add('city')
            ->add('status')
            ->add('created_by')
            ->add('edit_by')
            ->add('updated_at_formatted', fn (Career $model) => Carbon::parse($model->updated_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::action('Id'),

            Column::make('Created at (YYYY-MM-DD)', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Title', 'title')
                ->sortable()
                ->searchable(),

            Column::make('Designation', 'designation')
                ->sortable()
                ->searchable(),

            Column::make('State', 'state')
                ->searchable(),

            Column::make('City', 'city')
                ->searchable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Created By', 'created_by')
                ->sortable()
                ->searchable(),

            Column::make('Edit By', 'edit_by')
                ->sortable()
                ->searchable(),

            Column::make('Updated at (YYYY-MM-DD)', 'updated_at_formatted', 'updated_at')
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('title')->placeholder('Title'),
            Filter::inputText('created_at')->placeholder('YYYY-MM-DD (Created At)'),
            Filter::inputText('designation')->placeholder('Designation'),
            Filter::inputText('state')->placeholder('State'),
            Filter::inputText('city')->placeholder('city'),

            Filter::select('status')
                ->dataSource(Career::select('status')->groupBy('status')->get())
                ->optionLabel('status')
                ->optionValue('status'),
        ];
    }

    public function actions(Career $row): array
    {
        return [
            Button::add('CR'.$row->id)
                ->slot('CR'.$row->id)
                ->class('text-bold')
                ->route('careers.show', ['career' => $row])
                ->can(allowed: auth()->check()),
        ];
    }
    
}
