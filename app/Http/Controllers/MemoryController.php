<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemoryRequest;
use App\Http\Requests\UpdateMemoryRequest;
use App\Models\Memory;
use Illuminate\Http\Request;

class MemoryController extends Controller
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
            "data" => Memory::all()
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMemoryRequest $request)
    {
        if ($request->user()->role != "admin") {
            return [
                'state' => false,
                'message' => 'Usuario no autorizado'
            ];
        }

        $data = $request->validated();
        $new_memory = new Memory;

        $image = $new_memory->saveImage($data['images'], 500, 500);
        $new_memory->name = $data['name'];
        $new_memory->description = $data['description'];
        $new_memory->image = $image;
        $new_memory->save();

        return [
            'state' => true,
            'message' => 'Memoria creada correctamente.'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function show(Memory $memory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMemoryRequest $request, Memory $memory)
    {
        if ($request->user()->role != "admin") {
            return [
                'state' => false,
                'message' => 'Usuario no autorizado'
            ];
        }
        $data = $request->validated();

        if (isset($data['images'])) {
            $memory->deleteImage();
            $memory->image = $memory->saveImage($data['images'], 500, 500);
        }
        $memory->name = $data['name'];
        $memory->description = $data['description'];
        $memory->save();
        return [
            'state' => true,
            'message' => 'Memoria actualizada.'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Memory $memory)
    {
        if ($request->user()->role != "admin") {
            return [
                'state' => false,
                'message' => 'Usuario no autorizado'
            ];
        }
        $memory->deleteImage();
        $memory->delete();
        return [
            'state' => true,
            'message' => 'Memoria eliminada'
        ];
    }
}
