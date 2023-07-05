<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Routes\RoutesController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [RoutesController::class, 'dashboard'])->name('dashboard');
    Route::prefix('/admin-')->group(function () {
        Route::get('product/{product}', [RoutesController::class, 'product'])->name('product');
        Route::get('products', [RoutesController::class, 'products'])->name('products');
        Route::get('product-dump', [RoutesController::class, 'productos_dump'])->name('products.dump');
    });

});
