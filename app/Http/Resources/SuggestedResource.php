<?php

namespace App\Http\Resources;

use App\Models\Group;
use App\Models\Product;
use App\Models\Category;
use App\Models\Suggestion;
use App\Models\TypeProduct;
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
        // return parent::toArray($request);
        $suggestion = Suggestion::find($this->suggestion_id);
        $product = Product::find($this->product_id);
        $type_product = TypeProduct::find($product->type_product_id);
        $category = Category::find($product->category_id);
        $group = Group::find($category->group_id);
        $price = $product->price()->select('price')->get();
        return [
            'suggested_id' => $this->id,
            'suggestion_id' => $suggestion->id,
            'suggestion_name' => $suggestion->name,
            'id' => $product->id,
            'category_id' => $product->category_id,
            'type_product_id' => $product->type_product_id,
            'type_image' => $type_product->image,
            'group_id' => $group->id,

            'category_name' => $category->name,
            'product_type_name' => $type_product->name,
            'group_name' => $group->name,

            'remaining_products' => $product->remaining_products(),
            'new' => $product->is_new(),

            'name' => $product->name,
            'code' => $product->code,
            'price' => $price->value('price'),
            'units' => $product->units,
            'description' => $product->description,
            'available' => $product->available,
            'image' => $product->image()->select('name')->value('name'),
            'images' => $product->images()->select('id', 'name')->get(),

        ];
    }
}
