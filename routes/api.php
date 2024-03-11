<?php

use App\Http\Controllers\Api\MasterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/provinces', [MasterController::class, 'getProvinces'])->name('api.provinces');
Route::get('/districts/{provinceId}', [MasterController::class, 'getDistricts'])->name('api.districts');
Route::get('/wards/{districtId}', [MasterController::class, 'getWards'])->name('api.wards');
