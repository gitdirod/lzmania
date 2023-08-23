<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SuggestedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $type_product = $this->product->typeProduct;
        $product = $this->product;
        $category = $this->product->category;
        $group = $this->product->category->group;

        return [
            'suggestion' => [
                'id' => $this->suggestion->id,
                'name' => $this->suggestion->name,
            ],
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
            ],
            'type_product' => [
                'id' => $type_product->id,
                'name' => $type_product->name,
                'image' => $type_product->image,
            ],
            'group' => [
                'id' => $group->id,
                'name' => $group->name
            ],

            'id' => $product->id,
            'suggested_id' => $this->id,
            'new' => $product->is_new(),

            'name' => $product->name,
            'code' => $product->code,
            'price' => $product->price,
            'units' => $product->units,
            'description' => $product->description,
            'available' => $product->units > 0 ? $product->available : false,
            'images' => $product->images()->select('id', 'name')->get(),

        ];
    }
}
