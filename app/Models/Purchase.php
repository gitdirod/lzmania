<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\PurchaseProduct;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\PurchaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function product_name()
    {
        return $this->hasOne(Product::class);
    }

    public function products()
    {
        // return $this->belongsToMany(Product::class, 'purchase_products')->withPivot('quantity', 'subtotal', 'price');
        return $this->hasMany(PurchaseProduct::class);

        // return $this->hasMany(PurchaseProduct::class)->with('product_name');
    }

    public function products1()
    {
        // return $this->belongsToMany(Product::class, 'purchase_products')->withPivot('quantity', 'subtotal', 'price');
        return $this->belongsToMany(Product::class, 'purchase_products')
            ->withPivot('quantity', 'subtotal', 'price')
            ->select('name', 'code');

        // return $this->hasMany(PurchaseProduct::class)->with('product_name');
    }

    public function insertProducts($products)
    {
        $Array_products = [];
        foreach ($products as $product) {
            $find_pro = Product::where('id', $product['id'])->first();
            if (isset($find_pro)) {
                $pro = Product::find($product['id']);
                $price = number_format((float)$product['price'], 3, '.', '');

                $new = new PurchaseProduct;
                $new->purchase_id = $this->id;
                $new->product_id = $pro->id;
                $new->quantity = (int)$product['quantity'];
                $new->price = $price;
                $new->subtotal = $price * $product['quantity'];
                $new->save();

                $pro->updateUnits();
                $pro->updatePrice();

                // $Array_products[] = [
                //     'purchase_id' => $this->id,
                //     'product_id' => $pro->id,
                //     'quantity' => (int)$product['quantity'],
                //     // 'price' => $price,
                //     'price' => $price,
                //     'subtotal' => $price * $product['quantity'],
                //     'created_at' => Carbon::now(),
                //     'updated_at' => Carbon::now()
                // ];
            }
        }
        //Save on DB
        // PurchaseProduct::insert($Array_products);
        // return $Array_products;
    }
    public function updateProducts($products)
    {
        // Eliminar productos que no estan presentes
        $new_products_id_issets = collect($products)->pluck('id')->map(function ($id) {
            return (int)$id;
        });

        $old_products_id_issets = PurchaseProduct::where('purchase_id', $this->id)->pluck('product_id');
        for ($i = 0; $i < count($old_products_id_issets); $i++) {
            if (!$new_products_id_issets->contains($old_products_id_issets[$i])) {
                $item = PurchaseProduct::where([
                    'purchase_id' => $this->id,
                    'product_id' => $old_products_id_issets[$i]
                ])->first();
                $to_delete = PurchaseProduct::find((int)$item['id']);
                $product_id = $to_delete->product_id;
                $to_delete->delete();

                $product_delete = Product::find($product_id);
                $product_delete->updateUnits();
                $product_delete->updatePrice();
            }
        }
        // FIN Eliminar productos que no estan presentes


        $Array_products = [];
        foreach ($products as $product) {



            $find_pro = PurchaseProduct::where([
                'purchase_id' => $this->id,
                'product_id' => $product['id']
            ])->first();

            if (isset($find_pro)) {
                $pro = PurchaseProduct::find((int)$find_pro['id']);
                $Array_products[] = ['pro' => $pro];
                $pro->quantity = (int)$product['quantity'];
                $price = number_format((float)$product['price'], 3, '.', '');
                $pro->price = $price;
                $pro->subtotal = $price * (int)$product['quantity'];
                $pro->save();
            } else {
                $new = new PurchaseProduct;
                $price = number_format((float)$product['price'], 3, '.', '');
                $new->purchase_id = $this->id;
                $new->product_id = $product['id'];
                $new->quantity = (int)$product['quantity'];
                $new->price = $price;
                $new->subtotal = $price * (int)$product['quantity'];
                $new->save();
            }

            $product_update = Product::find($product['id']);
            $product_update->updateUnits();
            $product_update->updatePrice();
        }

        return $Array_products;
    }
}
