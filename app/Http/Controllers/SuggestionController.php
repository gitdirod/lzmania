<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSuggestionRequest;
use App\Http\Requests\UpdateSuggestionRequest;
use App\Models\Suggestion;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [
            "data" => Suggestion::all()
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSuggestionRequest $request)
    {
        $user = $request->user();
        $datos =  $request->validated();
        if ($user->role == 'admin') {
            $suggestion = new Suggestion;
            $suggestion->name = $datos['name'];
            $suggestion->save();
            return [
                "message" => "Sugerencia creada.",
                "state" => true
            ];
        }
        return [
            "message" => "Usuario no valido.",
            "state" => false
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */
    public function show(Suggestion $suggestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSuggestionRequest $request, Suggestion $suggestion)
    {
        $user = $request->user();
        $datos = $request->validated();
        if ($user->role == "admin") {
            $suggestion->name = $datos['name'];
            $suggestion->save();
            return [
                "message" => "Nombre actualizado.",
                "state" => true
            ];
        } else {
            return [
                "message" => "Usuario NO autorizado.",
                "state" => false
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Suggestion $suggestion)
    {
        //
    }
}
