<?php

use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\SearchController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/dang-nhap', [UserController::class, 'login'])->name('user.login');
Route::post('/dang-nhap', [UserController::class, 'loginPost'])->name('user.login.post');
Route::get('/dang-ky', [UserController::class, 'register'])->name('user.register');
Route::post('dang-ky', [UserController::class, 'registerPost'])->name('user.register.post');
Route::get('/tim-kiem', [SearchController::class, 'index'])->name('user.search');

Route::group(['middleware' => 'auth'], function () {
    Route::get("yeu-thich", [UserController::class, "getWhiteList"])->name("user.white_list");
    Route::get("dang-xuat", [UserController::class, "logout"])->name("user.logout");
    Route::get("thong-tin-ca-nhan", [UserController::class, "profile"])->name("user.profile");

    Route::get('gio-hang', [CartController::class, 'index'])->name('user.cart');
    Route::post('/gio-hang', [CartController::class, 'update'])->name('user.cart.update');
    Route::get('/gio-hang/xoa', [CartController::class, 'clean'])->name('user.cart.clean');
    Route::get('/gio-hang/xoa-san-pham/{id}', [CartController::class, 'remove'])->name('user.cart.remove');
    Route::get('/gio-hang/thanh-toan', [CartController::class, 'checkout'])->name('user.cart.checkout');
    Route::post('/gio-hang/thanh-toan', [CartController::class, 'checkoutPost'])->name('user.cart.checkout.post');
});

Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('user.add_to_cart');

Route::get("/", [HomeController::class, "index"])->name("home");
Route::prefix('danh-muc')->group(function () {
    Route::get('/{slug}', [CategoryController::class, 'index'])->name('user.category.index');
});

Route::get('/san-pham/{slug}', [ProductController::class, 'index'])->name('user.product.index');
