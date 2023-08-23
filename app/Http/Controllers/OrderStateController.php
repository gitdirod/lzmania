<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrderStateRequest;
use App\Models\OrderState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderState  $orderState
     * @return \Illuminate\Http\Response
     */
    public function show(OrderState $orderState)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderState  $orderState
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderStateRequest $request)
    {
        if (Auth::user()->role !== 'admin') {
            return [
                "message" => "Usuario no autorizado",
                "state" => false
            ];
        }

        $datos = $request->validated();
        $order_state = OrderState::find($datos['id']);
        // return [
        //     "orderState" => $order_state,
        //     "id" => $datos['id'],
        // ];
        // return gettype((int)$datos['state']);
        if ((int)$datos['state'] == 0) {
            $order_state->state = "EN BODEGA";
        } elseif ((int)$datos['state'] == 1) {
            $order_state->state = "EN TRAYECTO";
        } elseif ((int)$datos['state'] == 2) {
            $order_state->state = "ENTREGADO";
        } else {
            return [
                "message" => "Peticion invalida",
                "state" => false
            ];
        }
        $order_state->save();
        return [
            "message" => "Estado actualizado",
            "state" => true,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderState  $orderState
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderState $orderState)
    {
        //
    }
}
