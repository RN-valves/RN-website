<?php

namespace App\Livewire;

use App\Models\{
    ProductImage
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

final class ProductImagesIndex extends PowerGridComponent
{
    use WithExport;

    public int $product_id = 0;

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
        return ProductImage::query()->orderByDesc('id');
        /*return ProductImage::query()
            ->latest()
            ->when(
                $this->product_id,
                fn ($builder) => $builder->whereHas(
                    'product',
                    fn ($builder) => $builder->where('product_id', $this->product_id)
                )
                ->with(['product'])
            );*/
    }

    public function relationSearch(): array
    {
        return [
            'product' => [
                'article',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('created_at_formatted', fn (ProductImage $model) => Carbon::parse($model->created_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'))
            ->add('article', fn (ProductImage $model) => $model->product->article??'')
            ->add('sku_code')
            ->add('image')
            ->add('created_by')
            ->add('updated_at_formatted', fn (ProductImage $model) => Carbon::parse($model->updated_at)->timezone('Asia/Kolkata')->format('d M Y, H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::action('Id'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Article', 'article')
                ->searchable(),

            Column::make('Product Code', 'sku_code')
                ->sortable()
                ->searchable(),

            Column::make('Image', 'image')
                ->sortable()
                ->searchable(),

            Column::make('Created By', 'created_by')
                ->sortable()
                ->searchable(),

            Column::make('Updated at', 'updated_at_formatted', 'updated_at')
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('created_at')->placeholder('YYYY-MM-DD (Created At)'),
            // Filter::inputText('article')->placeholder('Article'),
            Filter::inputText('sku_code')->placeholder('Product Code'),
            Filter::inputText('image')->placeholder('Image'),
            Filter::inputText('created_by')->placeholder('Created By'),
            Filter::inputText('article')
                ->filterRelation('product', 'article'),
        ];
    }

    public function actions(ProductImage $row): array
    {
        return [
            Button::add('PRIMG'.$row->id)
                ->slot('PRIMG'.$row->id)
                ->class('text-bold')
                ->route('productImages.show', ['productImage' => $row])
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
