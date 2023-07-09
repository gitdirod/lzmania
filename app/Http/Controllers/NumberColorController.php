<?php

namespace App\Http\Controllers;

use App\Models\NumberColor;
use Illuminate\Http\Request;
use App\Http\Requests\StoreNumberColorRequest;
use App\Http\Requests\UpdateNumberColorRequest;

class NumberColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return [
            'data' => NumberColor::all()
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNumberColorRequest $request)
    {
        //
        if ($request->user()->role != "admin") {
            return [
                'state' => false,
                'message' => 'Usuario no autorizado'
            ];
        }

        $data = $request->validated();
        $new_number_colors = new NumberColor();

        $new_number_colors->name = $data['name'];
        $new_number_colors->save();

        return [
            'state' => true,
            'message' => 'Número de colores creado correctamente.'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NumberColor  $numberColor
     * @return \Illuminate\Http\Response
     */
    public function show(NumberColor $numberColor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NumberColor  $numberColor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNumberColorRequest $request, NumberColor $numberColor)
    {
        if ($request->user()->role != "admin") {
            return [
                'state' => false,
                'message' => 'Usuario no autorizado'
            ];
        }
        $data = $request->validated();
        $numberColor->name = $data['name'];
        $numberColor->save();
        return [
            'state' => true,
            'message' => 'Numero de colores actualizado.'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NumberColor  $numberColor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, NumberColor $numberColor)
    {
        if ($request->user()->role != "admin") {
            return [
                'state' => false,
                'message' => 'Usuario no autorizado'
            ];
        }
        $numberColor->delete();
        return [
            'state' => true,
            'message' => 'Número de colores eliminado'
        ];
    }
}
