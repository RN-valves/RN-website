<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Product;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'subcategory_id' => ['required','exists:subcategories,id'],
            'content_id' => ['required','exists:contents,id'],
            'brand' => ['required','exists:brands,name'],
            'material' => ['required','exists:materials,name'],
            'color_name' => ['required','exists:colors,name'],
            'name' => ['required','string','max:155'],
            'article' => ['required','string','max:15'],
            'sku_code' => ['required','string','max:15',Rule::unique(Product::class)->ignore($this->product->id)],
            'size' => ['required','exists:sizes,name'],
            'hsn' => ['required','string','max:25'],
            // 'image' => ['nullable','max:1024','mimes:jpg,jpeg,png,webp'],
            'title' => ['required','string','max:100'],
            'keywords' => ['required','string','max:155'],
            'description' => ['required','string','max:155'],
            'search_keywords' => ['required','string','max:255'],
            'is_visible_website' => ['required','in:0,1'],
            'is_visible_api' => ['required','in:0,1'],
            'new_arrival' => ['required','in:0,1'],
            'is_featured' => ['required','in:0,1'],
            'is_full_turn' => ['nullable','in:0,1'],
            'full_turn_code' => ['nullable','string','max:25'],
            'sale_type' => ['required','string','max:25'],
            'in_mrp' => ['required','numeric'],
            'in_selling' => ['required','numeric'],
            'in_v1_mrp' => ['required','numeric'],
            'oth_mrp' => ['required','numeric'],
            'oth_selling' => ['required','numeric'],
            'oth_v1_mrp' => ['required','numeric'],

            'color_group_id' => ['required','string','max:155'],
            'product_combo_id' => ['required','string','max:155'],
            'product_size_id' => ['required','string','max:155'],

            //product attributes validations
            'ctn_pcs' => ['required','numeric'],
            'mid_ctn_pcs' => ['required','numeric'],
            'inner_pcs' => ['required','numeric'],
            'stock_pcs' => ['required','numeric'],
            'only_product_wt_gm' => ['required','numeric'],
            'product_length' => ['required','numeric'],
            'product_breadth' => ['required','numeric'],
            'product_height' => ['required','numeric'],
            'product_lbh_weight_gm' => ['required','numeric'],
            'mid_ctn_lbh_weight_kg' => ['required','numeric'],
            'master_ctn_lbh_weight_kg' => ['required','numeric'],
            'residential_warranty' => ['required','numeric'],
            'commercial_warranty' => ['required','numeric'],
            'amazon_link' => ['nullable','string','max:255'],
            'flipkart_link' => ['nullable','string','max:255'],
            'short_description' => ['nullable','string','max:255'],
            'video_url' => ['nullable','string','max:255'],
        ];
    }
}
