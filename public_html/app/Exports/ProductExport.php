<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProductExport implements FromQuery, WithHeadings, WithMapping, WithChunkReading
{
    use Exportable;

    protected $categoryIds;
    protected $subcategoryIds;
    protected $isAllCategory;

    public function __construct(array $categoryIds = [], array $subcategoryIds = [], bool $isAllCategory = false)
    {
        $this->categoryIds    = $categoryIds;
        $this->subcategoryIds = $subcategoryIds;
        $this->isAllCategory  = $isAllCategory;
    }

    /**
     * Process records in chunks of 500 to avoid memory exhaustion
     * when exporting all/multiple categories.
     */
    public function chunkSize(): int
    {
        return 500;
    }

    public function query()
    {
        $query = Product::query()->with(['productAttribute', 'category', 'subcategory']);

        if (!$this->isAllCategory) {
            if (!empty($this->categoryIds)) {
                $query->whereIn('category_id', $this->categoryIds);
            }

            if (!empty($this->subcategoryIds)) {
                $query->whereIn('subcategory_id', $this->subcategoryIds);
            }
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'id', 'category', 'subcategory', 'content_id', 'brand', 'material', 'color_name', 'name', 'article',
            'sku_code', 'size', 'hsn', 'image', 'title', 'keywords', 'description', 'search_keywords',
            'is_visible_website', 'is_visible_api', 'new_arrival', 'is_featured', 'sale_type',
            'in_mrp', 'in_selling', 'in_v1_mrp', 'oth_mrp', 'oth_selling', 'oth_v1_mrp',
            'color_group_id', 'product_combo_id', 'product_size_id',
            'ctn_pcs', 'mid_ctn_pcs', 'inner_pcs', 'stock_pcs', 'only_product_wt_gm',
            'product_length', 'product_breadth', 'product_height', 'product_lbh_weight_gm',
            'mid_ctn_lbh_weight_kg', 'residential_warranty', 'commercial_warranty',
            'amazon_link', 'flipkart_link', 'short_description', 'video_url', 'is_full_turn', 'full_turn_code',
            'master_ctn_lbh_weight_kg', 'status',
        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            optional($product->category)->name,
            optional($product->subcategory)->name,
            $product->content_id,
            $product->brand,
            $product->material,
            $product->color_name,
            $product->name,
            $product->article,
            $product->sku_code,
            $product->size,
            $product->hsn,
            $product->image,
            $product->title,
            $product->keywords,
            $product->description,
            $product->search_keywords,
            $product->is_visible_website,
            $product->is_visible_api,
            $product->new_arrival,
            $product->is_featured,
            $product->sale_type,
            $product->in_mrp,
            $product->in_selling,
            $product->in_v1_mrp,
            $product->oth_mrp,
            $product->oth_selling,
            $product->oth_v1_mrp,
            $product->color_group_id,
            $product->product_combo_id,
            $product->product_size_id,
            optional($product->productAttribute)->ctn_pcs,
            optional($product->productAttribute)->mid_ctn_pcs,
            optional($product->productAttribute)->inner_pcs,
            optional($product->productAttribute)->stock_pcs,
            optional($product->productAttribute)->only_product_wt_gm,
            optional($product->productAttribute)->product_length,
            optional($product->productAttribute)->product_breadth,
            optional($product->productAttribute)->product_height,
            optional($product->productAttribute)->product_lbh_weight_gm,
            optional($product->productAttribute)->mid_ctn_lbh_weight_kg,
            optional($product->productAttribute)->residential_warranty,
            optional($product->productAttribute)->commercial_warranty,
            optional($product->productAttribute)->amazon_link,
            optional($product->productAttribute)->flipkart_link,
            optional($product->productAttribute)->short_description,
            optional($product->productAttribute)->video_url,
            $product->is_full_turn,
            $product->full_turn_code,
            optional($product->productAttribute)->master_ctn_lbh_weight_kg,
            $product->status,
        ];
    }
}
