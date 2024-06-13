<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

Route::controller(UserController::class)->group(function (){
    Route::post('register','register');
    Route::post('login','login');
    Route::post('logout','logout')->middleware('AssignGuardAdmins:user-api');
});

Route::controller(AdminController::class)->group(function () {
    Route::post('admin/login', 'login');
    Route::post('admin/logout', 'logout')->middleware('AssignGuardAdmins:admin-api');
});

Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);

Route::group(['middleware' => ['auth:admin-api']], function () {

});

Route::resource('categories', CategoryController::class);
Route::group(['middleware' => ['auth:user-api']], function () {
});
