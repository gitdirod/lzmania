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
use App\Models\PurchaseProduct;
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
    public function typeProduct()
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

    public function purchaseProducts()
    {
        return $this->hasMany(PurchaseProduct::class, 'product_id')->with('purchase');
    }
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'product_id');
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
        $this->name = $toUpdate["name"];
        $this->code = $toUpdate["code"];
        $this->category_id = $toUpdate["category"];
        $this->type_product_id = $toUpdate["type"];
        $this->description = $toUpdate["description"];
        $this->available = $toUpdate["available"];

        $this->size = $toUpdate["size"];
        $this->weight = $toUpdate["weight"];
        $this->number_color = $toUpdate["number_color"];
        $this->save();
    }

    public function remaining_products()
    {
        $sold = $this->orderProducts()->get();
        $suma = 0;
        if (is_Object($sold)) {
            foreach ($sold as $sol) {
                $order = Order::find($sol->order_id);
                $order_payment = $order->payment()->first();
                if ($order_payment->state === 'PAGADO') {
                    $suma += $sol->quantity;
                }
            }
        }
        return $this->units - $suma;
    }

    public function updateUnits()
    {
        // Actualiza total ingresado "Compras"
        $purchased_list = PurchaseProduct::where('product_id', $this->id)->pluck('quantity')->toArray();
        $purchased_total = array_sum($purchased_list);
        $this->purchased = $purchased_total;
        // $this->save();

        // Actualiza total egresado "ventas"
        $sold = $this->orderProducts()->get();
        $salida = 0;
        if (is_Object($sold)) {
            foreach ($sold as $sol) {
                $order = Order::find($sol->order_id);
                $order_payment = $order->payment()->first();
                if ($order_payment->state === 'PAGADO') {
                    $salida += $sol->quantity;
                }
            }
        }
        $this->sold = $salida;

        // Actualiza total disponible "inventario"
        $this->units = $purchased_total - $salida;
        $this->save();
    }
    public function updatePrice()
    {
        // Busca todos los productos comprados que coincidan con el ID del producto actual
        // y los ordena de forma descendente por el ID de compra.
        $purchased_list = PurchaseProduct::where('product_id', $this->id)
            ->orderBy('purchase_id', 'desc')
            ->get();

        // Verifica si la lista de productos comprados está vacía.
        if ($purchased_list->isEmpty()) {
            // Si la lista está vacía, establece el precio del producto a 0.
            $this->price = 0;
        } else {
            // Si la lista no está vacía, obtiene el primer elemento de la lista,
            // que corresponde al último producto comprado debido al ordenamiento previo.
            $last_price = $purchased_list->first();
            // Establece el precio del producto al precio del último producto comprado.
            $this->price = $last_price->price;
        }

        // Guarda los cambios en el producto, ya sea que el precio haya sido actualizado
        // o establecido a 0.
        $this->save();
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
    public function deleteImages($datos)
    {
        if (isset($datos)) {
            foreach ($datos as $to_delete) {
                $find_img = ProductImage::where('id', $to_delete['id'])->first();
                if (isset($find_img)) {
                    $path_file = "products/" . $find_img->name;
                    if (File::exists($path_file)) {
                        File::delete($path_file);
                    }
                    $find_img->delete();
                }
            }
        }
    }
}
