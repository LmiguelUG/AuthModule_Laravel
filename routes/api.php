<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::get('products', [\App\Http\Controllers\ProductController::class, 'index']);
// Route::post('products', [\App\Http\Controllers\ProductController::class, 'store']);
// Route::get('products/{producto}', [\App\Http\Controllers\ProductController::class, 'show']);
// Route::delete('products/{producto}', [\App\Http\Controllers\ProductController::class, 'destroy']);
// Route::put('products/{producto}', [\App\Http\Controllers\ProductController::class, 'update']);
Route::apiResource('products', \App\Http\Controllers\ProductController::class);
Route::put('like/{producto}', [\App\Http\Controllers\ProductController::class, 'set_like'])->name('like');
Route::put('dislike/{producto}', [\App\Http\Controllers\ProductController::class, 'set_dislike'])->name('dislike');