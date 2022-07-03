<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ACL\PermissionController;
use App\Http\Controllers\Admin\ACL\RoleController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\OrderController;
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

// admin
Route::get('/', [AdminController::class, 'index']);

// profile
Route::prefix('profile/')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile');

    Route::patch('/{user}/update', [ProfileController::class, 'update'])->name('profile.update');

    // two factor auth
    Route::post('/twoFactorAuth', [ProfileController::class, 'sendCode'])->name('profile.twoFactorAuth');

    Route::get('/twoFactorAuth', [ProfileController::class, 'verifyPage'])->name('profile.verifyPage');

    Route::post('/verifyPhoneNumber', [ProfileController::class, 'verifyPhoneNumber'])->name('profile.verifyPhoneNumber');
});

// users
Route::resource('/users', UserController::class);

Route::get('/users/setAcl/{user}', [UserController::class, 'setAcl'])->name('users.addAcl');

Route::post('/users/setAcl/{user}', [UserController::class, 'setAclToDB'])->name('users.setAcl');

// categories
Route::resource('/categories', CategoryController::class);

Route::get('/categories/addChild/{category}', [CategoryController::class, 'addChild'])->name('categories.addChild');

// products
Route::resource('products', ProductController::class);

// attributes
Route::resource('attributes', AttributeController::class);

// comments
Route::resource('comments', CommentController::class)->except(['show', 'edit', 'create', 'store']);

// ACL
    // permissions
Route::resource('permissions', PermissionController::class)->middleware('can:acl-control');

    // roles
Route::resource('roles', RoleController::class)->middleware('can:acl-control');


// orders
Route::resource('orders', OrderController::class);

Route::post('orders/pay/{order}', [OrderController::class, 'pay'])->name('orders.pay');

// Discount 
Route::resource('discounts', DiscountController::class);