<?php

namespace App\Livewire;

use App\Models\{
    News,
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

final class NewsIndex extends PowerGridComponent
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
        //return Category::query()->with(['content']);
        return News::query()
            ->latest();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('created_at_formatted', fn (News $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'))
            ->add('name')
            ->add('title')
            ->add('url_key')
            ->add('created_by')
            ->add('status')
            ->add('published_at_formatted', fn (News $model) => Carbon::parse($model->published_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'));
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

            Column::make('SEO Title', 'title')
                ->sortable()
                ->searchable(),

            Column::make('URL', 'url_key')
                ->sortable()
                ->searchable(),
                
            Column::make('Created By', 'created_by')
                ->sortable()
                ->searchable(),
                
            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Published at', 'published_at_formatted', 'published_at')
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('created_at')->placeholder('YYYY-MM-DD (Created At)'),
            Filter::inputText('published_at')->placeholder('YYYY-MM-DD (Published At)'),
            Filter::inputText('name')->placeholder('Name'),
            Filter::inputText('url_key')->placeholder('URL'),
            Filter::inputText('title')->placeholder('Title'),

            Filter::select('status')
                ->dataSource(News::select('status')->groupBy('status')->get())
                ->optionLabel('status')
                ->optionValue('status'),
        ];
    }

    public function actions(News $row): array
    {
        return [
            Button::add('NW'.$row->id)
                ->slot('NW'.$row->id)
                ->class('text-bold')
                ->route('news.show', ['news' => $row])
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
