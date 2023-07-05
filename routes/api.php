<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Products\ProductsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ->middleware(['auth:sanctum'])
Route::prefix('/products')->group(function () {

    Route::get('/', [ProductsController::class, 'products']);

    Route::post('/create-product', [ProductsController::class, 'create']);

    Route::delete('/delete-product', [ProductsController::class, 'delete']);

    Route::delete('/permanent-delete-product', [ProductsController::class, 'permanent_delete']);

    Route::post('/restore-product', [ProductsController::class, 'restore']);

    Route::put('/update-product', [ProductsController::class, 'update']);
});
