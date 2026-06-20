<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
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
            'name' => $this->name,
            'article' => $this->article,
            'sku_code' => $this->sku_code,
            'size' => $this->size,
            'color_name' => $this->color_name,
            'in_mrp' => $this->in_mrp,
            'in_selling' => $this->in_selling,
            'image' => url($this->image),
        ];
    }
}
