<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSizeRequest;
use App\Http\Requests\UpdateSizeRequest;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
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
            'data' => Size::all()
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSizeRequest $request)
    {
        //
        if ($request->user()->role != "admin") {
            return [
                'state' => false,
                'message' => 'Usuario no autorizado'
            ];
        }

        $data = $request->validated();
        $new_memory = new Size();

        $new_memory->name = $data['name'];
        $new_memory->save();

        return [
            'state' => true,
            'message' => 'Tamaño creado correctamente.'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSizeRequest $request, Size $size)
    {
        if ($request->user()->role != "admin") {
            return [
                'state' => false,
                'message' => 'Usuario no autorizado'
            ];
        }
        $data = $request->validated();

        $size->name = $data['name'];
        $size->save();
        return [
            'state' => true,
            'message' => 'Tamaño actualizado.'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Size $size)
    {
        if ($request->user()->role != "admin") {
            return [
                'state' => false,
                'message' => 'Usuario no autorizado'
            ];
        }
        $size->delete();
        return [
            'state' => true,
            'message' => 'Tamaño eliminado'
        ];
    }
}
