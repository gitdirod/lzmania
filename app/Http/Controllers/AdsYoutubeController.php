<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdsYoutubeCollection;
use App\Models\AdsYoutube;
use App\Services\AdsYoutubeService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;



class AdsYoutubeController extends Controller
{
    use ApiResponse;
    protected $adsYoutubeService;


    public function __construct(AdsYoutubeService $adsYoutubeService)
    {
        // Se aplica el middleware de autenticación a todos los métodos excepto 'index' y 'show'
        $this->middleware('auth')->except(['index', 'show']);

        // Asegura que el usuario puede realizar acciones de administrador solo para los métodos 'store' y 'update'
        $this->middleware('can:admin')->only(['store', 'update', 'destroy']);
        $this->adsYoutubeService = $adsYoutubeService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adsYoutube = new AdsYoutubeCollection(AdsYoutube::all());
        return $this->successResponse("Grupos recuperados con exito.", $adsYoutube);

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
     * @param  \App\Models\AdsYoutube  $adsYoutube
     * @return \Illuminate\Http\Response
     */
    public function show(AdsYoutube $adsYoutube)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdsYoutube  $adsYoutube
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdsYoutube $adsYoutube)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdsYoutube  $adsYoutube
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdsYoutube $adsYoutube)
    {
        //
    }
}
