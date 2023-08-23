<?php

namespace App\Models;

use App\Models\Group;
use Illuminate\Support\Str;
use App\Models\CategoryImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Intervention\Image\Facades\Image as ImageIntervention;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'group_id'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    public function isShowed()
    {
        $products = $this->products()->get();
        $thereProducts = $products->filter(function ($product) {
            return isset($product['units']) && $product['units'] > 0 && $product['available'] == true;
        });

        $isShow = $thereProducts->isNotEmpty();
        return $isShow ? true : false;
    }
    public function images()
    {
        return $this->hasMany(CategoryImage::class, 'category_id');
    }
    public function updateCategory(array $toUpdate)
    {
        $this->name = $toUpdate["name"];
        $this->group_id = $toUpdate["group_id"];
        $this->save();
    }
    public function insertImages(array $datos)
    {
        foreach ($datos['images'] as $image) {
            $name_image = Str::uuid() . "." . $image->extension();
            $image_server = ImageIntervention::make($image);
            $image_server->resize(300, 300);
            $image_path = public_path('categories') . '/' . $name_image;
            $image_server->save($image_path);

            CategoryImage::create([
                'category_id' => $this->id,
                'name' => $name_image,
            ]);
        }
    }
    public function deleteImages(array $datos)
    {

        if (isset($datos)) {
            foreach ($datos as $obj) {

                $path_file = "categories/" . $obj->name;
                if (File::exists($path_file)) {
                    File::delete($path_file);
                }
                $toDelete = ProductImage::find($obj->id);
                $toDelete->delete();
            }
        }
    }
}
