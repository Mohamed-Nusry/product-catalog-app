<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;

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

//Product API routes
Route::group(["prefix" => "products"], function () {
    Route::get('/', [ProductApiController::class, 'index']);
    Route::get('/{id}', [ProductApiController::class, 'show']);
    Route::post('/store', [ProductApiController::class, 'store']);
    Route::put('/update/{id}', [ProductApiController::class, 'update']);
    Route::delete('/delete/{id}', [ProductApiController::class, 'destroy']);
});
