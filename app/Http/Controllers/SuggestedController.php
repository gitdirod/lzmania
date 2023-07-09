<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSuggestedRequest;
use App\Http\Resources\SuggestedCollection;
use App\Models\Suggested;
use Illuminate\Http\Request;

class SuggestedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new SuggestedCollection(Suggested::orderBy('id', 'DESC')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSuggestedRequest $request)
    {
        $datos = $request->validated();

        $user = $request->user();
        if ($user->role == "admin") {
            $find_suggested = Suggested::where('product_id', $datos['product_id'])->first();
            if (isset($find_suggested)) {
                $suggested = Suggested::find($find_suggested->id);
                $suggested->delete();
                return [
                    'message' => "Item eliminado de lista.",
                    'state' => true
                ];
            } else {
                $suggested = new Suggested;
                $suggested->suggestion_id = $datos['suggestion_id'];
                $suggested->product_id = $datos['product_id'];
                $suggested->save();
                return [
                    'message' => "Item agregado de lista.",
                    'state' => true
                ];
            }
        } else {
            return [
                'message' => "Usuario no autorizado.",
                'state' => false
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Suggested  $suggested
     * @return \Illuminate\Http\Response
     */
    public function show(Suggested $suggested)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Suggested  $suggested
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Suggested $suggested)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Suggested  $suggested
     * @return \Illuminate\Http\Response
     */
    public function destroy(Suggested $suggested)
    {
        //
    }
}
