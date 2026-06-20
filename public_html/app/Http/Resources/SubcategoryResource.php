<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubcategoryResource extends JsonResource
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
            'image' => url($this->image),
            'banner' => url($this->banner),
            'icon' => url($this->icon),
        ];
    }
}
