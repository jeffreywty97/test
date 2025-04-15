<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'product_name'  => $this->product_name,
            'description'   => $this->description,
            'price'         => $this->price,
            'stock'         => $this->stock,
            'enabled'       => $this->enabled,
            'category_id'   => $this->category->id ?? null,
            'category_name' => $this->category->name ?? null,
        ];
    }
}
