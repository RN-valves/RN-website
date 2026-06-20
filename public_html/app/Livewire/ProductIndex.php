<?php

namespace App\Livewire;

use App\Models\{
    Category,
    Subcategory,
    Product,
    Material
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

final class ProductIndex extends PowerGridComponent
{
    use WithExport;
    public int $subcategory_id = 0;
    public int $category_id = 0;

    public function setUp(): array
    {
        $this->showCheckBox();
        return [
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
        //return Product::query();
        return Product::query()
            ->orderByDesc('id')
            ->when(
                $this->subcategory_id,
                fn ($builder) => $builder->whereHas(
                    'subcategory',
                    fn ($builder) => $builder->where('subcategory_id', $this->subcategory_id)
                )
                ->with(['subcategory','category','content','productAttribute'])
            );
    }

    public function relationSearch(): array
    {
        return [
            'subcategory' => [
                'name',
            ],
            'category' => [
                'name',
            ],
            'content' => [
                'title',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('created_at_formatted', fn (Product $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'))
            ->add('category_id', fn (Product $model) => $model->category->name??'')
            ->add('subcategory_id', fn (Product $model) => $model->subcategory->name??'')
            ->add('name', fn (Product $model) => substr($model->name, 0, 25) )
            ->add('article')
            ->add('sku_code')
            ->add('material')
            ->add('color_name')
            ->add('size')
            ->add('in_mrp')
            ->add('in_selling')
            ->add('stock_pcs', fn (Product $model) => $model->productAttribute->stock_pcs??0)
            ->add('status')
            ->add('is_visible_website', fn (Product $model) => $model->is_visible_website ? 'Visible' : 'InVisible')
            ->add('color_group_id')
            ->add('product_size_id');
    }

    public function columns(): array
    {
        return [
            Column::action('Id'),

            Column::make('Category', 'category_id')
                ->sortable()
                ->searchable(),

            Column::make('Subcategory', 'subcategory_id')
                ->sortable()
                ->searchable(),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),
                
            Column::make('Article', 'article')
                ->sortable()
                ->searchable(),
                
            Column::make('Product Code', 'sku_code')
                ->sortable()
                ->searchable(),
                
            Column::make('Material', 'material')
                ->sortable()
                ->searchable(),
                
            Column::make('Color Name', 'color_name')
                ->sortable()
                ->searchable(),
                
            Column::make('Size', 'size')
                ->sortable()
                ->searchable(),
                
            Column::make('MRP(IN)', 'in_mrp')
                ->sortable()
                ->searchable(),
                
            Column::make('Selling(IN)', 'in_selling')
                ->sortable()
                ->searchable(),
                
            Column::make('Stock (Pcs)', 'stock_pcs')
                ->sortable()
                ->searchable(),
                
            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),
                
            Column::make('Is Visible Web?', 'is_visible_website')
                ->sortable()
                ->searchable(),
                
            Column::make('Color Group Id', 'color_group_id')
                ->sortable()
                ->searchable(),
                
            Column::make('Size Group Id', 'product_size_id')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            // Filter::inputText('name', 'name')
            //  ->operators(['contains', 'is', 'is_not']),
            Filter::inputText('created_at')->placeholder('YYYY-MM-DD (Created At)'),
            Filter::inputText('name')->placeholder('Name'),
            //Filter::inputText('in_mrp')->placeholder('MRP(IN)'),
            //Filter::inputText('in_selling')->placeholder('Selling(IN)'),
            //Filter::inputText('stock_pcs')->placeholder('Stock (Pcs)'),
            Filter::inputText('article')->placeholder('Article'),
            Filter::inputText('sku_code')->placeholder('Product Code'),
            Filter::inputText('color_name')->placeholder('Color'),
            Filter::inputText('size')->placeholder('Size'),
            Filter::inputText('is_visible_website')->placeholder('Is Visible Web?'),
            Filter::inputText('color_group_id')->placeholder('Color Group Id'),
            Filter::inputText('product_size_id')->placeholder('Size Group Id'),

            Filter::inputText('subcategory_id')
                ->filterRelation('subcategory', 'name'),

            Filter::select('category_id')
                ->dataSource(Category::select('id','name')->get())
                ->optionLabel('name')
                ->optionValue('id'),

            Filter::select('status')
                ->dataSource(Product::select('status')->groupBy('status')->get())
                ->optionLabel('status')
                ->optionValue('status'),

            Filter::select('material')
                ->dataSource(Material::select('name')->get())
                ->optionLabel('name')
                ->optionValue('name'),

            Filter::boolean('is_visible_website', 'is_visible_website')
                ->label('Visible', 'InVisible'),
        ];
    }

    public function actions(Product $row): array
    {
        return [
            Button::add('PR'.$row->id)
                ->slot('PR'.$row->id)
                ->class('text-bold')
                ->route('products.show', ['product' => $row])
                ->can(allowed: auth()->check()),

            Button::make('View', ' | View')
                ->class('text-bold text-success')
                ->route('productList.view', [$row->category->url_key, $row->subcategory->url_key, $row])
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
