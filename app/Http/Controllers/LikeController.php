<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateLikeRequest;
use App\Http\Requests\ShowLikeRequest;
use App\Http\Resources\LikeCollection;
use App\Models\ProductImage;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if (isset($user)) {
            return new LikeCollection(
                Like::select('id', 'product_id')
                    ->with('product')
                    ->where('user_id', Auth::user()->id)
                    ->orderBy('id', 'DESC')
                    ->get()
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLikeRequest $request)
    {
        $datos = $request->validated();

        $user = User::find(Auth::user()->id);
        $product = Product::find($datos['product_id']);
        $like = [];

        if (!empty($product)) {
            $like = $user->likes->firstWhere('product_id', $product->id);
        } else {
            return [
                'message' => "Producto no existente"
            ];
        }

        if (empty($like)) {
            if (isset($user) && isset($product)) {
                Like::create([
                    'user_id' => $user->id,
                    'product_id' => $datos['product_id']
                ]);
                return [
                    'like' => true,
                    'state' => true,
                    'message' => 'Te gusta!'
                ];
            }
        } else {
            $like_deleted = Like::find($like->id);
            $like_deleted->delete();
            return [
                'like' => false,
                'state' => true,
                'message' => 'No te gusta!'
            ];
        }

        return [
            'message' => "Debes inicar secion",
            'state' => false,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function show(ShowLikeRequest $request)
    {
        $datos = $request->validated();

        $user = User::find($datos['user_id']);
        $product = Product::find($datos['product_id']);
        if (!empty($product) && !empty($user)) {
            $like = $user->likes->firstWhere('product_id', $product->id);
            if (!empty($like)) {
                return ['like' => true];
            }
        }
        return ['like' => false];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(Like $like)
    {
        //
    }
}
