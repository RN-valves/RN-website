<?php

namespace App\Livewire;

use App\Models\Faq;
use Livewire\Component;
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

class FaqIndex extends PowerGridComponent
{
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
        //return Category::query()->with(['content']);
        return Faq::query()
            ->latest();
            
    }

    // public function relationSearch(): array
    // {
    //     return [
    //         'category' => [
    //             'name',
    //         ],
    //     ];
    // }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('created_at_formatted', fn (Faq $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'))
            ->add('title')
            ->add('answer');
    }

    public function columns(): array
    {
        return [
            Column::action('Id'),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Question', 'title')
                ->sortable()
                ->searchable(),

            Column::make('Answer', 'answer')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('created_at')->placeholder('YYYY-MM-DD (Created At)'),
            Filter::inputText('title')->placeholder('Question'),
            Filter::inputText('answer')->placeholder('Answer'),
        ];
    }

    public function actions(Faq $row): array
    {
        return [
            Button::add('Edit')
                ->slot('Edit')
                ->class('btn btn-primary btn-sm')
                ->can(allowed: auth()->check()),
        ];
    }
}
