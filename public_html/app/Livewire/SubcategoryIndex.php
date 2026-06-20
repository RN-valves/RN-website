<?php

namespace App\Livewire;

use App\Models\{
    Subcategory,
    Content,
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

final class SubcategoryIndex extends PowerGridComponent
{
    use WithExport;
    public int $category_id = 0;
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
        //return Subcategory::query()->with(['content']);
        return Subcategory::query()
            ->latest()
            ->when(
                $this->category_id,
                fn ($builder) => $builder->whereHas(
                    'category',
                    fn ($builder) => $builder->where('category_id', $this->category_id)
                )
                ->with(['category','content'])
            );
    }

    public function relationSearch(): array
    {
        return [
            'category' => [
                'name',
            ],
            'content' => [
                'name',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('pdf_catalogue', fn (Subcategory $model) => $model->pdf_catalogue ? '<img width="60" src="' . asset($model->pdf_catalogue) . '">' : 'N/A')
            ->add('created_at_formatted', fn (Subcategory $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'))
            ->add('category_id', fn (Subcategory $model) => $model->category->name??'')
            ->add('name')
            ->add('url_key')
            ->add('title')
            ->add('content_name', fn (Subcategory $model) => $model->content->title??'')
            ->add('status')
            ->add('productsCount', fn (Subcategory $model) => $model->products->count())
            ->add('is_visible_website', fn (Subcategory $model) => $model->is_visible_website ? 'Yes' : 'No');
    }

    public function columns(): array
    {
        return [
            Column::action('Id'),
            Column::make('PDF Catalogue', 'pdf_catalogue'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Category', 'category_id')
                ->sortable()
                ->searchable(),

            Column::make('Name', 'name')
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
                
            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),
                
            Column::make('Products', 'productsCount')
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
            Filter::inputText('url_key')->placeholder('URL'),
            Filter::inputText('title')->placeholder('Title'),

            Filter::select('status')
                ->dataSource(Subcategory::select('status')->groupBy('status')->get())
                ->optionLabel('status')
                ->optionValue('status'),

            Filter::inputText('content_name')
                ->filterRelation('content', 'name'),

            Filter::select('category_id')
                ->dataSource(Category::select('id','name')->get())
                ->optionLabel('name')
                ->optionValue('id'),

            /*Filter::inputText('category')
                ->filterRelation('category', 'name'),*/
        ];
    }

    public function actions(Subcategory $row): array
    {
        return [
            Button::add('SBCAT'.$row->id)
                ->slot('SBCAT'.$row->id)
                ->class('text-bold')
                ->route('subcategories.show', ['subcategory' => $row])
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
