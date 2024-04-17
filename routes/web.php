<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfirmCount;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', function () {
    return php_ini_loaded_file();
});


Route::get('/db-test', function () {
    try {
        \DB::connection()->getPdo();
        return 'Conectado a la base de datos correctamente.';
    } catch (\Exception $e) {
        return 'No se pudo conectar a la base de datos: ' . $e->getMessage();
    }
});

