<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\{
    Page
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

class PageIndex extends PowerGridComponent
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
        return Page::query()
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
            ->add('created_at_formatted', fn (Page $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'))
            ->add('name')
            ->add('title')
            ->add('url_key');
    }

    public function columns(): array
    {
        return [
            Column::action('Id'),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Title', 'title')
                ->sortable()
                ->searchable(),

            Column::make('URL', 'url_key')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('created_at')->placeholder('YYYY-MM-DD (Created At)'),
            Filter::inputText('name')->placeholder('Name'),
            Filter::inputText('url_key')->placeholder('URL'),
            Filter::inputText('title')->placeholder('Title'),
        ];
    }

    public function actions(Page $row): array
    {
        return [
            Button::add('PG'.$row->id)
                ->slot('PG'.$row->id)
                ->class('text-bold')
                ->route('page.edit', ['url_key' => $row->url_key])
                ->can(allowed: auth()->check()),
        ];
    }

}
