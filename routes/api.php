<?php

// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Headers: Accept,Authorization,Content-Type');

use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\ProductCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ShippingController;
use App\Http\Controllers\API\TransactionController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('products', [ProductController::class, 'all']);
Route::get('product/{id}', [ProductController::class, 'single']);
Route::get('price/{id}', [ProductController::class, 'singlePrice']);
Route::get('categories', [ProductCategoryController::class, 'all']);
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserController::class, 'fetch']);
    Route::post('update', [UserController::class, 'updateUser']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('transaction', [TransactionController::class, 'all']);
    Route::post('shipping/price', [ShippingController::class, 'getPrice']);
    Route::get('shipping/province', [ShippingController::class, 'getProvince']);
    Route::get('shipping/cities/{id}', [ShippingController::class, 'getCities']);
    Route::post('add/to/cart', [CartController::class, 'add']);
    Route::post('place-order', [CheckoutController::class, 'placeorder']);
    Route::put('update/cart/{id}/{scope}', [CartController::class, 'update']);
    Route::delete('delete/cart/{id}', [CartController::class, 'deleteCart']);
    Route::get('cart', [CartController::class, 'cart']);
});
