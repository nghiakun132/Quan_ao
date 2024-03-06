<?php

use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/dang-nhap', [UserController::class, 'login'])->name('user.login');
Route::post('/dang-nhap', [UserController::class, 'loginPost'])->name('user.login.post');
Route::get('/dang-ky', [UserController::class, 'register'])->name('user.register');
Route::post('dang-ky', [UserController::class, 'registerPost'])->name('user.register.post');

Route::group(['middleware' => 'auth'], function () {
    Route::get("/", [HomeController::class, "index"])->name("home");
    Route::get("dang-xuat", [UserController::class, "logout"])->name("user.logout");
    Route::get("thong-tin-ca-nhan", [UserController::class, "profile"])->name("user.profile");
});
