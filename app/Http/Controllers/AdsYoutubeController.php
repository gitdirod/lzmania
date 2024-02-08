<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdsYoutubeStoreRequest;
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
        return $this->successResponse("Ads recuperados con exito.", $adsYoutube);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdsYoutubeStoreRequest $request)
    {
        try {
            $datos = $request->validated();
            $adsYoutube = $this->adsYoutubeService->createAdsYoutube($datos['name'], $datos['url']);
            return $this->successResponse('Ads Youtube creado.', $adsYoutube, 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear el Ads Youtube.', $e->getMessage());
        }
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
        // Aqui quedo para continuar
        try {
            $datos = $request->validated();
            $group = $this->groupService->updateGroup($group->id, $datos['name']);
            return $this->successResponse('Grupo actualizado.');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->errorResponse('Error al actualizar el grupo en base de datos.', $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorResponse('Error inesperado al actualizar el grupo.', $e->getMessage());
        }
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
