<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateOrderPaymentRequest;

class OrderPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return "hola";
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
     * @param  \App\Models\OrderPayment  $orderPayment
     * @return \Illuminate\Http\Response
     */
    public function show(OrderPayment $orderPayment)
    {
        return "show";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderPayment  $orderPayment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderPaymentRequest $request)
    {

        if (Auth::user()->role !== 'admin') {
            return [
                "message" => "Usuario no autorizado",
                "state" => false
            ];
        }

        $datos = $request->validated();
        $order_payment = OrderPayment::find($datos['id']);
        if ((int)$datos['state'] == 1) {
            $order_payment->state = "PAGADO";
        } elseif ((int)$datos['state'] == 0) {
            $order_payment->state = "POR PAGAR";
        } else {
            return [
                "message" => "Peticion invalida",
                "state" => false
            ];
        }
        $order_payment->save();
        return [
            "message" => "Pago actualizado",
            "state" => true
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderPayment  $orderPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderPayment $orderPayment)
    {
        //
    }
}
