<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image as ImageIntervention;
use Illuminate\Support\Str;

class TypeProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
    ];

    public function insertImages(array $datos)
    {
        foreach ($datos['images'] as $image) {
            $name_image = Str::uuid() . "." . $image->extension();
            $image_server = ImageIntervention::make($image);
            if ($image_server->width() > $image_server->height()) {
                $image_server->widen(100);
            } elseif ($image_server->height() > $image_server->width()) {
                $image_server->heighten(100);
            } else {
                $image_server->resize(100, 100);
            }
            $image_path = public_path('iconos') . '/' . $name_image;
            $image_server->save($image_path);

            return $name_image;
        }
    }
}
