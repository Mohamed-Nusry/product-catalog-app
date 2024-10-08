<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

//Redirect to product page on load
Route::get('/', function () {
    return redirect('/products');
});

//Redirect after login to product page
Route::get('/home', function () {
    return redirect('/products');
});

//Product routes
Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
});