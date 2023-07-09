<?php

namespace App\Http\Resources;

// use auth;
use App\Models\Group;
use App\Models\Category;
use App\Models\TypeProduct;
use Illuminate\Support\Facades\Auth;
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
        // return parent::toArray($request);
        $user = auth()->user();
        $type_product = TypeProduct::find($this->type_product_id);
        $category = Category::find($this->category_id);
        $group = Group::find($category->group_id);
        $price = $this->price()->select('price')->get();

        return [
            'id' => $this->id,

            'category_id' => $this->category_id,
            'type_product_id' => $this->type_product_id,
            'type_image' => $type_product->image,
            'group_id' => $group->id,

            'category_name' => $category->name,
            'product_type_name' => $type_product->name,
            'group_name' => $group->name,
            'remaining_products' => $this->remaining_products(),
            'new' => $this->is_new(),

            'name' => $this->name,
            'code' => $this->code,
            'weight' => $this->weight,
            'size' => $this->size,
            'number_color' => $this->number_color,
            'price' => $price->value('price'),
            'units' => $this->units,
            'description' => $this->description,
            'available' => $this->available,
            'image' => $this->image()->select('name')->value('name'),
            'images' => $this->images()->select('id', 'name')->get(),
        ];
    }
}
