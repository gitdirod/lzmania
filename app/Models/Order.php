<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Unit;
use App\Models\User;
use App\Models\Address;
use App\Models\Payment;
use App\Models\Product;
use App\Models\OrderState;
use Illuminate\Support\Str;
use App\Models\OrderPayment;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Intervention\Image\Facades\Image as ImageIntervention;

class Order extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')->withPivot('quantity', 'subtotal', 'price')->with('images');
    }
    public function payment()
    {
        return $this->hasOne(OrderPayment::class, 'order_id')->latest();
    }
    public function state()
    {
        return $this->hasOne(OrderState::class, 'order_id')->latest();
    }
    public function paymentImages()
    {
        return $this->hasMany(Payment::class, 'order_id')->latest();
    }
    public function addresses()
    {
        return $this->hasMany(OrderAddress::class, 'order_id')->latest();
    }

    public function insertImages($images)
    {
        $user = Auth::user();
        foreach ($images as $image) {
            $name_image = Str::uuid() . "." . $image->extension();
            $image_server = ImageIntervention::make($image);
            if ($image_server->width() > $image_server->height()) {
                $image_server->widen(700);
            } elseif ($image_server->height() > $image_server->width()) {
                $image_server->heighten(700);
            } else {
                $image_server->resize(700, 700);
            }
            $image_path = public_path('payments') . '/' . $name_image;
            $image_server->save($image_path);

            $pay = Payment::create([
                'order_id' => $this->id,
                'user_id' => $user->id,
                'name' => $name_image
            ]);
            return $pay;
        }
    }

    public function insertPayment()
    {
        OrderPayment::create([
            'order_id' => $this->id,
            'state' => "POR PAGAR",
        ]);
    }
    public function insertState()
    {
        OrderState::create([
            'order_id' => $this->id,
            'state' => "EN BODEGA",
        ]);
    }
    public function insertAddress($address_id)
    {
        $find_address_send = Address::where('id', $address_id)->first();
        if (isset($find_address_send)) {
            $add = Address::find($find_address_send->id);
            $address = new OrderAddress;
            $address->order_id = $this->id;
            $address->envoice = $add->envoice;
            $address->people = $add->people;
            $address->ccruc = $add->ccruc;
            $address->city = $add->city;
            $address->address = $add->address;
            $address->phone = $add->phone->number;
            $address->save();
            return $address;
        }
        return false;
    }
    public function insertProducts($products)
    {
        $Array_products = [];
        foreach ($products as $product) {
            $find_pro = Product::where('id', $product['id'])->first();
            if (isset($find_pro)) {
                $pro = Product::find($product['id']);
                $price = (int)$pro->price()->select('price')->value('price');

                $unit = new Unit;
                $unit->product_id = $pro->id;
                $unit->quantity = (int)$product['quantity'];
                $unit->order_id = $this->id;
                $unit->save();

                $Array_products[] = [
                    'order_id' => $this->id,
                    'product_id' => $pro->id,
                    'quantity' => (int)$product['quantity'],
                    'price' => $price,
                    'subtotal' => $price * $product['quantity'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
        }
        //Save on DB
        OrderProduct::insert($Array_products);
        return $Array_products;
    }

    public function checkQuantityProducts($products)
    {
        foreach ($products as $product) {
            $find_pro = Product::where('id', $product['id'])->first();
            if (isset($find_pro)) {

                $pro = Product::find($product['id']);
                if (($pro->remaining_products() < (int)$product['quantity'])) {
                    return false;
                }
            } else {
                return false;
            }
        }
        return true;
    }
}
