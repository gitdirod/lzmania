<?php

use App\Models\User;
use App\Models\Memory;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfirmCount;
use App\Http\Resources\UserCollection;
use App\Http\Resources\ProductResource;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MemoryController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SuggestedController;
use App\Http\Controllers\OrderStateController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\NumberColorController;
use App\Http\Controllers\TypeProductController;
use App\Http\Controllers\LandingImageController;
use App\Http\Controllers\OrderPaymentController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\EmailVerificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum', 'verified')->group(function () {
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return new UserResource(User::findOrFail($request->user()->id));
    });
    Route::get('/users', [AuthController::class, 'index']);

    Route::post('/logout', [AuthController::class, 'logout']);

    //Almacenar ordenes

    Route::apiResource('orders', OrderController::class);

    Route::apiResource('/likes', LikeController::class);

    Route::apiResource('/payments', PaymentController::class);

    Route::apiResource('order_payment', OrderPaymentController::class);

    Route::apiResource('order_state', OrderStateController::class);

    Route::apiResource('addresses', AddressController::class);



    Route::apiResource('sizes', SizeController::class);

    Route::apiResource('number_colors', NumberColorController::class);
});
Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('throttle:fourByHour', 'auth:sanctum',)->name('verification.send');
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware(['throttle:2'])->name('verification.verify');


// Confirm count
Route::post('/confirm', [ConfirmCount::class, 'store']);

// Sizes
// Route::apiResource('sizes', SizeController::class)->except([
//     'create', 'store', 'update', 'destroy'
// ]);
// Route::middleware('auth:sanctum')->post('sizes', [SizeController::class, 'store']);
// Route::middleware('auth:sanctum')->put('sizes/{size}', [SizeController::class, 'update']);
// Route::middleware('auth:sanctum')->put('sizes/{size}', [SizeController::class, 'destroy']);

// Memories
Route::apiResource('memories', MemoryController::class)->except([
    'create', 'store', 'update', 'destroy'
]);
Route::middleware('auth:sanctum')->post('memories', [MemoryController::class, 'store']);
Route::middleware('auth:sanctum')->put('memories/{memory}', [MemoryController::class, 'update']);
Route::middleware('auth:sanctum')->delete('memories/{memory}', [MemoryController::class, 'destroy']);

// suggesteds
Route::apiResource('/suggesteds', SuggestedController::class)->except([
    'create', 'store', 'update', 'destroy'
]);
Route::middleware('auth:sanctum')->post('suggesteds', [SuggestedController::class, 'store']);
Route::middleware('auth:sanctum')->delete('suggesteds/{suggested}', [SuggestedController::class, 'update']);

// suggestions
Route::apiResource('suggestions', SuggestionController::class)->except([
    'create', 'store', 'update', 'destroy'
]);
Route::middleware('auth:sanctum')->post('suggestions', [SuggestionController::class, 'store']);
Route::middleware('auth:sanctum')->put('suggestions/{suggestion}', [SuggestionController::class, 'update']);

// Landing
Route::apiResource('/landings', LandingImageController::class)->except([
    'create', 'store', 'update', 'destroy'
]);
Route::middleware('auth:sanctum')->post('/landings', [LandingImageController::class, 'store']);

// Products
Route::apiResource('/products', ProductController::class)->except([
    'create', 'store', 'update', 'destroy'
]);
Route::middleware('auth:sanctum')->post('/products', [ProductController::class, 'store']);
Route::middleware('auth:sanctum')->put('/products/{product}', [ProductController::class, 'update']);

// Categories
Route::apiResource('/categories', CategoryController::class)->except([
    'create', 'store', 'update', 'destroy'
]);
Route::middleware('auth:sanctum')->post('/categories', [CategoryController::class, 'store']);
Route::middleware('auth:sanctum')->put('/categories/{category}', [CategoryController::class, 'update']);

// Type products
Route::get('/type_products', [TypeProductController::class, 'index']);
Route::middleware('auth:sanctum')->post('/type_products', [TypeProductController::class, 'store']);
Route::get('/type_products/{type_product}', [TypeProductController::class, 'show']);
Route::middleware('auth:sanctum')->put('/type_products/{type_product}', [TypeProductController::class, 'update']);

// Groups
Route::middleware('auth:sanctum')->get('/groups', [GroupController::class, 'index']);
Route::middleware('auth:sanctum')->post('/groups', [GroupController::class, 'store']);
Route::middleware('auth:sanctum')->get('/groups/{group}', [GroupController::class, 'show']);
Route::middleware('auth:sanctum')->put('/groups/{group}', [GroupController::class, 'update']);

// Groups
Route::apiResource('products.product_image', ProductImageController::class);



//Autenticacion
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/login', function () {

    return "ok";
})->name('login');

Route::get('/mostrar/{request}', function ($request) {

    echo $request;
})->name('mostrar');
