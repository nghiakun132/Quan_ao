<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

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
include_once "user.php";

const ADMIN_PREFIX = 'admin';
const THEM_MOI = 'them-moi';
const SUA = 'sua/{id}';
const CAP_NHAT = 'cap-nhat/{id}';
const XOA = 'xoa/{id}';


Route::prefix('/admin')->group(function () {

    Route::get('/dang-nhap', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/danh-nhap', [AdminController::class, 'loginPost'])->name('admin.login.post');

    Route::group(['middleware' => 'auth:admins'], function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');

        Route::get('/dang-xuat', [AdminController::class, 'logout'])->name('admin.logout');

        Route::group(['prefix' => 'danh-muc'], function () {
            Route::get('/', [CategoryController::class, 'index'])->name('admin.category.index');
            Route::post(THEM_MOI, [CategoryController::class, 'store'])->name('admin.category.store');
            Route::get(SUA, [CategoryController::class, 'edit'])->name('admin.category.edit');
            Route::post(CAP_NHAT, [CategoryController::class, 'update'])->name('admin.category.update');
            Route::get(XOA, [CategoryController::class, 'destroy'])->name('admin.category.delete');
        });

        Route::group(['prefix' => 'nha-san-xuat'], function () {
            Route::get('/', [BrandController::class, 'index'])->name('admin.brand.index');
            Route::post(THEM_MOI, [BrandController::class, 'store'])->name('admin.brand.store');
            Route::get(SUA, [BrandController::class, 'edit'])->name('admin.brand.edit');
            Route::post(CAP_NHAT, [BrandController::class, 'update'])->name('admin.brand.update');
            Route::get(XOA, [BrandController::class, 'destroy'])->name('admin.brand.delete');
        });

        Route::group(['prefix' => 'san-pham'], function () {
            Route::get('/', [ProductController::class, 'index'])->name('admin.product.index');
            Route::get(THEM_MOI, [ProductController::class, 'create'])->name('admin.product.create');
            Route::post(THEM_MOI, [ProductController::class, 'store'])->name('admin.product.store');
            Route::get(SUA, [ProductController::class, 'edit'])->name('admin.product.edit');
            Route::post(CAP_NHAT, [ProductController::class, 'update'])->name('admin.product.update');
            Route::get(XOA, [ProductController::class, 'destroy'])->name('admin.product.delete');
        });

        Route::group(['prefix' => 'kich-thuoc'], function () {
            Route::get('/', [SizeController::class, 'index'])->name('admin.size.index');
            Route::post(THEM_MOI, [SizeController::class, 'store'])->name('admin.size.store');
            Route::get(SUA, [SizeController::class, 'edit'])->name('admin.size.edit');
            Route::post(CAP_NHAT, [SizeController::class, 'update'])->name('admin.size.update');
            Route::get(XOA, [SizeController::class, 'destroy'])->name('admin.size.delete');
        });

        //order
        Route::group(['prefix' => 'don-hang'], function () {
            Route::get('/', [OrderController::class, 'index'])->name('admin.order.index');
            Route::get('/{id}', [OrderController::class, 'show'])->name('admin.order.show');

            Route::post('update/{id}', [OrderController::class, 'updateStatus'])->name('admin.order.updateStatus');
        });

        Route::group(['prefix' => 'khach-hang'], function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.user.index');
            Route::get('/thay-doi-trang-thai/{id}', [UserController::class, 'changeStatus'])
                ->name('admin.user.changeStatus');
        });

        Route::group(['prefix' => 'ma-giam-gia'], function () {
            Route::get('/', [DiscountController::class, 'index'])->name('admin.discount.index');
            Route::post(THEM_MOI, [DiscountController::class, 'store'])->name('admin.discount.store');
            Route::get(SUA, [DiscountController::class, 'edit'])->name('admin.discount.edit');
            Route::post(CAP_NHAT, [DiscountController::class, 'update'])->name('admin.discount.update');
            Route::delete(XOA, [DiscountController::class, 'destroy'])->name('admin.discount.delete');
        });
    });

});
