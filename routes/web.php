<?php

use App\Http\Controllers\API\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MyTransactionController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\VariantController;

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

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
   
    Route::name('dashboard.')->prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        
        Route::middleware(['admin'])->group(function () {
            Route::get('exportcategory', [ProductCategoryController::class, 'exportCategory'])->name('category.export');
            Route::post('importcategory', [ProductCategoryController::class, 'import'])->name('category.import');
            Route::resource('product', ProductController::class);
            Route::resource('category', ProductCategoryController::class);
            Route::resource('product.gallery', ProductGalleryController::class)->shallow()->only([
                'index', 'create', 'store', 'destroy'
            ]);
            Route::resource('variant', VariantController::class)->except('index', 'create', 'store');
            Route::get('variant/create/{id}', [VariantController::class, 'create'])->name('variant.create');
            Route::post('variant/{id}', [VariantController::class, 'store'])->name('variant.store');
            Route::resource('transaction', TransactionController::class)->only([
                'index', 'show', 'edit', 'update'
            ]);
            Route::resource('user', UserController::class)->only([
                'index', 'edit', 'update', 'destroy'
            ]);
        });
    });
});