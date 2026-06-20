<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ProductAttribute;

class ProductDeailResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'url_key' => $this->url_key,
            'category' => $this->category->name,
            'subcategory' => $this->subcategory->name,
            'brand' => $this->brand,
            'name' => $this->name,
            'material' => $this->material,
            'article' => $this->article,
            'sku_code' => $this->sku_code,
            'size' => $this->size,
            'hsn' => $this->hsn,
            'color_name' => $this->color_name,
            'in_mrp' => $this->in_mrp,
            'in_selling' => $this->in_selling,
            'in_v1_mrp' => $this->in_v1_mrp,
            'title' => $this->title,
            'keywords' => $this->keywords,
            'description' => $this->description,
            'search_keywords' => $this->search_keywords,
            'status' => $this->status,
            'is_visible_website' => $this->is_visible_website,
            'is_visible_api' => $this->is_visible_api,
            'new_arrival' => $this->new_arrival,
            'is_featured' => $this->is_featured,
            'sale_type' => $this->sale_type,
            'image' => url($this->image),
            'color_icon' => url($this->color_icon),
            'content' => $this->content->content,
            'attributes' => ProductAttribute::select('ctn_pcs','inner_pcs','stock_pcs','only_product_wt_gm','product_length','product_breadth','product_height','product_lbh_weight_gm','mid_ctn_lbh_weight_kg','master_ctn_lbh_weight_kg','residential_warranty','commercial_warranty','amazon_link','flipkart_link','short_description','video_url')->where('product_id', $this->id)->first(),
        ];
    }
}
