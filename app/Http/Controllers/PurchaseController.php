<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoragePurchaseRequest;
use App\Http\Resources\PurchaseCollection;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user() && Auth::user()->role == 'admin') {
            return new PurchaseCollection(
                Purchase::with('user')
                    ->orderBy('id', 'DESC')
                    ->get()
            );
        } else {
            return [
                'message' => "Usuario no autorizado",
                'state' => false,
            ];
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoragePurchaseRequest $request)
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

        $purchase = new Purchase;
        $purchase->user_id = Auth::user()->id;
        $purchase->envoice = $datos['envoice'];
        $purchase->subtotal = $datos['subtotal'];
        $purchase->save();

        $purchase->insertProducts($datos['products']);

        return [
            'message' => 'Compra realizada correctamente.',
            'state' => true,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(StoragePurchaseRequest $request, Purchase $purchase)
    {
        $datos = $request->validated();
        // return $purchase->updateProducts($datos['products']);
        $purchase_products = $purchase->updateProducts($datos['products']);

        // return $purchase_products;
        $purchase->envoice = $datos['envoice'];
        $purchase->subtotal = $datos['subtotal'];
        $purchase->save();

        return [
            'message' => 'Compra actualizada.',
            'state' => true,
            'products' => $purchase_products,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
