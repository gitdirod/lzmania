<?php

namespace App\Http\Controllers;

use App\Models\TypeProduct;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\TypeProductCollection;
use App\Http\Requests\StoreTypeProductRequest;
use App\Http\Requests\UpdateTypeProductRequest;
use Intervention\Image\Facades\Image as ImageIntervention;

class TypeProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new TypeProductCollection(TypeProduct::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTypeProductRequest $request, TypeProduct $typeProduct)
    {
        $user = $request->user();
        if ($user->role != "admin") {
            return [
                'message' => "Usuario NO autorizado",
                'state' => false
            ];
        }

        $datos = $request->validated();
        if (isset($datos["images"])) {
            foreach ($datos['images'] as $image) {

                // $image = head($datos["images"]);
                $name_image = Str::uuid() . "." . $image->extension();
                $image_server = ImageIntervention::make($image);

                if ($image_server->width() > $image_server->height()) {
                    $image_server->widen(64);
                } elseif ($image_server->height() > $image_server->width()) {
                    $image_server->heighten(64);
                } else {
                    $image_server->resize(64, 64);
                }
                $image_path = public_path('icons') . '/' . $name_image;
                $image_server->save($image_path);

                // $image->move(public_path('icons'), $name_image);

                $typeProduct = TypeProduct::create([
                    'name' => $datos['name'],
                    'image' => $name_image
                ]);
                return true;
            }
        }

        return [
            'message' => "Tipo de producto creado.",
            'state' => true,
            'data' => $typeProduct
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeProduct  $typeProduct
     * @return \Illuminate\Http\Response
     */
    public function show(TypeProduct $typeProduct)
    {
        return [
            'id' => $typeProduct->id,
            'name'  => $typeProduct->name,
        ];
    }

    /**
     * Update the specified resource in storage.
     *s
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypeProduct  $typeProduct
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTypeProductRequest $request, TypeProduct $typeProduct)
    {

        $user = $request->user();
        if ($user->role != "admin") {
            return [
                'message' => "Usuario NO autorizado",
                'state' => false
            ];
        }

        $datos = $request->validated();

        if (isset($datos["images"])) {
            $path_file = "icons/" . $typeProduct->image;
            if (File::exists($path_file)) {
                File::delete($path_file);
            }

            $image = head($datos["images"]);
            $name_image = Str::uuid() . "." . $image->extension();
            $image->move(public_path('icons'), $name_image);

            $typeProduct->name = $datos["name"];
            $typeProduct->image = $name_image;
            $typeProduct->save();
        }

        $typeProduct->name = $datos["name"];
        $typeProduct->save();

        return [
            'message' => "Tipo actualizado",
            'state' => true,
            'data' => $typeProduct
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeProduct  $typeProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeProduct $typeProduct)
    {
        //
    }
}
