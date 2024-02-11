<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $type_product = $this->typeProduct;
        $group = $this->category->group;

        return [
            'category' => [
                'id' => $this->category_id,
                'name' => $this->category->name,
            ],
            'type_product' => [
                'id' => $this->type_product_id,
                'name' => $type_product->name,
                'image' => $type_product->image,
            ],
            'group' => [
                'id' => $group->id,
                'name' => $group->name
            ],
            'id' => $this->id,
            'new' => $this->is_new(),
            'name' => $this->name,
            'code' => $this->code,
            'discount' => $this->discount,
            'weight' => $this->weight,
            'size' => $this->size,
            'number_color' => $this->number_color,
            'price' => $this->price,
            'units' => $this->units,
            'purchased' => $this->purchased,
            'sold' => $this->sold,
            'description' => $this->description,
            'available' => $this->units > 0 ? $this->available : false,
            'images' => $this->images()->select('id', 'name')->get(),
        ];
    }
}
