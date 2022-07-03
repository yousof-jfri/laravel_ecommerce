<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;

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

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products/{product:slug}', [HomeController::class, 'productDetails'])->name('home.productDetails');

Route::post('/products/comment', [HomeController::class, 'newComment'])->name('home.newComment')->middleware('auth');

Route::get('/products', [HomeController::class, 'AllProducts'])->name('home.all');



// shopping cart
Route::get('/cart', [HomeController::class, 'shoppingCart'])->name('home.shoppingCart');

Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');

Route::patch('cart/quantity/update/{quantity}/{id}', [CartController::class, 'updateCard'])->name('cart.update');

Route::delete('cart/delete/{product}',  [CartController::class, 'deleteCart'])->name('cart.delete');

// Order
Route::middleware('auth')->group(function(){
    Route::post('payment', [PaymentController::class, 'payment'])->name('cart.payment');
});