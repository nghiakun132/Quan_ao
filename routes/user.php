<?php

use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\OrderController;
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
    Route::get("yeu-thich/{id}", [UserController::class, "addWhiteList"])->name("user.white_list.add");
    Route::get("dang-xuat", [UserController::class, "logout"])->name("user.logout");
    Route::get("thong-tin-ca-nhan", [UserController::class, "profile"])->name("user.profile");
    Route::post("thong-tin-ca-nhan", [UserController::class, "update"])->name("user.profile.update");
    Route::get('dia-chi-giao-hang', [UserController::class, 'getAddress'])->name('user.address');
    Route::post('dia-chi-giao-hang', [UserController::class, 'addAddress'])->name('user.address.store');
    Route::get('dia-chi-giao-hang/{id}', [UserController::class, 'editAddress'])->name('user.address.edit');
    Route::post('dia-chi-giao-hang/{id}', [UserController::class, 'updateAddress'])->name('user.address.update');
    Route::get('dia-chi-giao-hang/xoa/{id}', [UserController::class, 'deleteAddress'])->name('user.address.delete');
    Route::get('/mac-dinh/{id}', [UserController::class, 'setDefaultAddress'])->name('user.address.default');

    Route::post('/doi-mat-khau', [UserController::class, 'changePassword'])->name('user.change_password');

    Route::get('gio-hang', [CartController::class, 'index'])->name('user.cart');
    Route::post('/gio-hang', [CartController::class, 'update'])->name('user.cart.update');
    Route::get('/gio-hang/xoa', [CartController::class, 'clean'])->name('user.cart.clean');
    Route::get('/gio-hang/xoa-san-pham/{id}', [CartController::class, 'remove'])->name('user.cart.remove');
    Route::get('/gio-hang/thanh-toan', [CartController::class, 'checkout'])->name('user.cart.checkout');
    Route::post('/gio-hang/thanh-toan', [CartController::class, 'checkoutPost'])->name('user.cart.checkout.post');
    Route::get('/don-hang', [OrderController::class, 'index'])->name('user.order');
    Route::get('/don-hang/{code}', [OrderController::class, 'show'])->name('user.order.show');
    Route::post('/huy-don-hang', [OrderController::class, 'cancel'])->name('user.order.cancel');

    Route::post('them-ma', [CartController::class, 'applyDiscount'])->name('user.cart.apply_discount');
    Route::get('xoa-ma', [CartController::class, 'removeDiscount'])->name('user.cart.remove_discount');
});

Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('user.add_to_cart');

Route::get("/", [HomeController::class, "index"])->name("home");
Route::prefix('danh-muc')->group(function () {
    Route::get('/{slug}', [CategoryController::class, 'index'])->name('user.category.index');
});

Route::get('/san-pham/{slug}', [ProductController::class, 'index'])->name('user.product.index');
