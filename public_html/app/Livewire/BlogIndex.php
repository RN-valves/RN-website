<?php

namespace App\Livewire;

use App\Models\{
    Blog,
    Category
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

final class BlogIndex extends PowerGridComponent
{
    use WithExport;
    public int $category_id = 0;
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
        return Blog::query()
            ->latest()
            ->when(
                $this->category_id,
                fn ($builder) => $builder->whereHas(
                    'category',
                    fn ($builder) => $builder->where('category_id', $this->category_id)
                )
                ->with(['category'])
            );
    }

    public function relationSearch(): array
    {
        return [
            'category' => [
                'name',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('category', fn (Blog $model) => $model->category->name)
            ->add('created_at_formatted', fn (Blog $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'))
            ->add('name')
            ->add('title')
            ->add('url_key')
            ->add('created_by')
            ->add('status')
            ->add('published_at_formatted', fn (Blog $model) => Carbon::parse($model->published_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::action('Id'),

            Column::make('Category', 'category')
                ->sortable()
                ->searchable(),

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
                ->dataSource(Blog::select('status')->groupBy('status')->get())
                ->optionLabel('status')
                ->optionValue('status'),

            Filter::select('category_id')
                ->dataSource(Category::select('id','name')->get())
                ->optionLabel('name')
                ->optionValue('id'),
        ];
    }

    public function actions(Blog $row): array
    {
        return [
            Button::add('BL'.$row->id)
                ->slot('BL'.$row->id)
                ->class('text-bold')
                ->route('blogs.show', ['blog' => $row])
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
