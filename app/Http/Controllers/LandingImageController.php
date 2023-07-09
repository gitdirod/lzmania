<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLandingRequest;
use App\Models\LandingImage;
use Illuminate\Http\Request;

class LandingImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [
            "data" => [
                0 => LandingImage::where('type', 0)->first(),
                1 => LandingImage::where('type', 1)->first(),
                2 => LandingImage::where('type', 2)->first(),
            ]
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLandingRequest $request)
    {
        $datos =  $request->validated();
        $user = $request->user();
        if ($user->role != "admin") {
            return [
                'message' => "Usuario NO autorizado",
                'state' => false
            ];
        }

        $w = 0;
        $h = 0;
        if ($datos['type'] == 0) {
            $w = 600;
            $h = 1000;
        } elseif ($datos['type'] == 1) {
            $w = 1200;
            $h = 1200;
        } elseif ($datos['type'] == 2) {
            $w = 3200;
            $h = 1200;
        } else {
            return [
                "message" => "Dimensiones incorrectas",
                "state" => false
            ];
        }

        if ($user->role == 'admin') {
            $find_item = LandingImage::where("type", $datos['type'])->first();
            if (empty($find_item)) {
                $landing = new LandingImage;

                $landing->name = $landing->saveImage($datos['images'], $w, $h);
                $landing->type = $datos['type'];
                $landing->save();

                return  [
                    "data" => $landing,
                    "state" => true,
                    "message" => "Creado correctamente."
                ];
            } else {
                $landing = LandingImage::find($find_item->id);

                $landing->deleteImage();

                $landing->name = $landing->saveImage($datos['images'], $w, $h);
                $landing->type = $datos['type'];
                $landing->save();

                return  [
                    "data" => $landing,
                    "state" => true,
                    "message" => "Actualizado correctamente."
                ];
            }
        }
        return [
            "message" => "Usuario no valido",
            "state" => false
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LandingImage  $landingImage
     * @return \Illuminate\Http\Response
     */
    public function show(LandingImage $landingImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LandingImage  $landingImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LandingImage $landingImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LandingImage  $landingImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(LandingImage $landingImage)
    {
        //
    }
}
