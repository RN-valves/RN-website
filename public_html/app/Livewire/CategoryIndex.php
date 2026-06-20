<?php

namespace App\Livewire;

use App\Models\{
    Category,
    Content
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

final class CategoryIndex extends PowerGridComponent
{
    use WithExport;
    public int $content_id = 0;
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
        return Category::query()
            ->latest()
            ->when(
                $this->content_id,
                fn ($builder) => $builder->whereHas(
                    'content',
                    fn ($builder) => $builder->where('content_id', $this->content_id)
                )
                ->with(['content'])
            );
    }

    public function relationSearch(): array
    {
        return [
            'content' => [
                'name',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('pdf_catalogue', fn (Category $model) => $model->pdf_catalogue ? '<img width="60" src="' . asset($model->pdf_catalogue) . '">' : 'N/A')
            ->add('created_at_formatted', fn (Category $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'))
            ->add('name')
            ->add('discount')
            ->add('tax')
            ->add('url_key')
            ->add('title')
            ->add('content_name', fn (Category $model) => $model->content->title??'')
            ->add('total_products', fn (Category $model) => $model->products->count())
            ->add('status')
            ->add('is_visible_website', fn (Category $model) => $model->is_visible_website ? 'Visible' : 'InVisible');
    }

    public function columns(): array
    {
        return [
            Column::action('Id'),
            Column::make('Catalogue', 'pdf_catalogue'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Discount%', 'discount')
                ->sortable()
                ->searchable(),

            Column::make('Tax%', 'tax')
                ->sortable()
                ->searchable(),

            Column::make('URL', 'url_key')
                ->sortable()
                ->searchable(),

            Column::make('SEO Title', 'title')
                ->sortable()
                ->searchable(),

            Column::make('ContentId', 'content_name')
                ->sortable()
                ->searchable(),
                
            Column::make('Products', 'total_products')
                ->sortable()
                ->searchable(),
                
            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),
                
            Column::make('is Visible?', 'is_visible_website')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('created_at')->placeholder('YYYY-MM-DD (Created At)'),
            Filter::inputText('name')->placeholder('Name'),
            Filter::inputText('discount')->placeholder('Discount %'),
            Filter::inputText('tax')->placeholder('Tax %'),
            Filter::inputText('url_key')->placeholder('URL'),
            Filter::inputText('title')->placeholder('Title'),

            Filter::select('status')
                ->dataSource(Category::select('status')->groupBy('status')->get())
                ->optionLabel('status')
                ->optionValue('status'),

            Filter::inputText('content_name')
                ->filterRelation('content', 'name'),
        ];
    }

    public function actions(Category $row): array
    {
        return [
            Button::add('CAT'.$row->id)
                ->slot('CAT'.$row->id)
                ->class('text-bold')
                ->route('categories.show', ['category' => $row])
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
