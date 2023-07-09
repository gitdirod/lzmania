<?php

namespace App\Models;




use Carbon\Carbon;
use App\Models\Like;
use App\Models\Order;
use App\Models\Category;
use Hamcrest\Type\IsObject;
use Illuminate\Support\Str;
use App\Models\OrderProduct;
use App\Models\ProductImage;
use App\Models\ProductPrice;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Intervention\Image\Facades\Image as ImageIntervention;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'type_product_id',
        'units',
        'description',
        'available',
        'code',
        'weight',
        'size',
        'number_color'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function type()
    {
        return $this->belongsTo(TypeProduct::class, 'type_product_id');
    }
    public function is_new()
    {
        $date_created = $this->created_at;
        $date = Carbon::now();
        $diff = $date_created->diffInDays($date);
        return $diff > 15 ? false : true;
    }

    // One To Many
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
    public function image()
    {
        return $this->hasOne(ProductImage::class, 'product_id')->latestOfMany();
    }
    public function price()
    {
        return $this->hasOne(ProductPrice::class, 'product_id')->latestOfMany();
    }
    // One to Many
    public function purchased()
    {
        return $this->hasMany(OrderProduct::class, 'product_id');
    }

    public function remaining_products()
    {
        $purchased = $this->purchased()->get();
        $suma = 0;
        if (is_Object($purchased)) {
            foreach ($purchased as $purch) {
                $order = Order::find($purch->order_id);
                $order_payment = $order->payment()->first();
                if ($order_payment->state === 'PAGADO') {
                    $suma += $purch->quantity;
                }
            }
        }
        return $this->units - $suma;
    }

    public function likes()
    {
        // return Auth::user()->id;
        return $this->hasMany(Like::class, 'product_id');
        // return Auth::user();
        // return $this->hasOne(Like::class, 'product_id')->where('user_id', 6)->latestOfMany();
    }

    public function updateProduct(array $toUpdate)
    {
        $category = Category::find($toUpdate["category"]);
        $this->name = $toUpdate["name"];
        $this->code = $toUpdate["code"];
        $this->category_id = $toUpdate["category"];
        $this->type_product_id = $toUpdate["type"];
        $this->units = $toUpdate["units"];
        $this->description = $toUpdate["description"];
        $this->available = $toUpdate["available"];

        $this->size = $toUpdate["size"];
        $this->weight = $toUpdate["weight"];
        $this->number_color = $toUpdate["number_color"];
        $this->save();

        ProductPrice::create([
            'product_id' => $this->id,
            'price' => $toUpdate["price"],
        ]);

        // $this->image = $category->image;
        // $this->price = $toUpdate["price"];
    }
    public function insertImages(array $datos)
    {
        foreach ($datos['images'] as $image) {
            $name_image = Str::uuid() . "." . $image->extension();
            $image_server = ImageIntervention::make($image);
            if ($image_server->width() > $image_server->height()) {
                $image_server->widen(700);
            } elseif ($image_server->height() > $image_server->width()) {
                $image_server->heighten(700);
            } else {
                $image_server->resize(700, 700);
            }
            $image_path = public_path('products') . '/' . $name_image;
            $image_server->save($image_path);

            ProductImage::create([
                'product_id' => $this->id,
                'name' => $name_image,
            ]);
        }
    }
    public function deleteImages(array $datos)
    {
        if (isset($datos['deleted'])) {
            foreach ($datos['deleted'] as $string) {
                $obj = json_decode($string);
                $path_file = "products/" . $obj->name;
                if (File::exists($path_file)) {
                    File::delete($path_file);
                }
                $toDelete = ProductImage::find($obj->id);
                $toDelete->delete();
            }
        }
    }
}
