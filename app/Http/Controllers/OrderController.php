<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderCollection;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->email_verified_at) {
            return [
                'state' => false,
                'message' => "Verifica primero tu cuenta"
            ];
        }

        if (Auth::user() && Auth::user()->role == 'admin') {
            return new OrderCollection(
                Order::with('user', 'products', 'payment', 'state', 'paymentImages', 'addresses')
                    ->orderBy('id', 'DESC')
                    ->get()
            );
        }
        return new OrderCollection(
            Order::with('products', 'payment', 'state', 'paymentImages')
                ->where('user_id', Auth::user()->id)
                ->orderBy('id', 'DESC')
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        if (!Auth::user()) {
            return [
                'state' => false,
                'message' => "Registrate"
            ];
        }

        if (!Auth::user()->email_verified_at) {
            return [
                'state' => false,
                'message' => "Verifica primero tu cuenta"
            ];
        }


        $datos = $request->validated();
        //Store order

        $order = new Order;
        if (!$order->checkQuantityProducts($datos['products'])) {
            return [
                'message' => 'Productos faltantes en bodega',
                'state' => false,
            ];
        }
        $order->user_id = Auth::user()->id;
        $order->total = $request->total;
        $order->subtotal = $request->subtotal;
        $order->save();

        //OrderState
        $order->insertState();
        //OrderPayment
        $order->insertPayment();
        // Address
        $order->insertAddress($datos['address_send_id']);
        $order->insertAddress($datos['address_envoice_id']);
        // Images
        if (isset($datos['images']) && count($datos['images']) > 0) {
            $order->insertImages($datos['images']);
        }
        // Products
        $order->insertProducts($datos['products']);

        return [
            'message' => 'Orden realizada correctamente.',
            'state' => true,
            // 'data' => new OrderResource(Order::findOrFail($order->id))
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        // $order = Order::find($order->id);
        // return [
        //     'id' => $order->id,
        //     'created_at' => $order->created_at,
        //     'updated_at' => $order->updated_at,
        //     'payment' => $order->payment()->select('state')->value('state'),
        //     'payment_images' => $order->paymentImages()->get(),
        //     'products' => $order->products()->get(),
        //     'state' => $order->payment()->select('state')->value('state'),
        //     'subtotal' => $order->subtotal,
        //     'total' => $order->total,
        //     'user' => $order->user()->first(),
        //     'user_id' => $order->user_id
        // ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $user = $request->user();
        if ($user->role != "admin" || !Auth::user()->email_verified_at) {
            return [
                'message' => "Usuario NO autorizado",
                'state' => false
            ];
        }
        $datos = $request->validated();
        $order->envoice = $datos['envoice'];
        $order->save();
        return [
            'state' => true,
            'message' => "Orden actualizada"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
