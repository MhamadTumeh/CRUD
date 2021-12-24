<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CoursesController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['cors', 'json.response']], function () {

 
    Route::post('/register', [UserAuthController::class, 'register'])->name('register.api');
    Route::post('/login', [UserAuthController::class, 'login'])->name('login.api');
    Route::get('/getUser', [UserAuthController::class, 'getUser']);


    Route::post('/logout', [UserAuthController::class, 'logout'])->middleware('auth:api')->name('logout.api');
    
    Route::post('/register-admin', [AdminAuthController::class, 'register'])->name('register.admin');
    Route::post('/login-admin', [AdminAuthController::class, 'login'])->name('login.admin');
   


    Route::post('/add-category', [CategoryController::class, 'store']);
    Route::get('/show-category', [CategoryController::class, 'show']);
    Route::post('/category/{id}/update', [CategoryController::class, 'update']);
    Route::get('/display-category', [CategoryController::class, 'index']);
    Route::post('/delete-category', [CategoryController::class, 'destroy']);


    Route::post('/upload-store', [CoursesController::class, 'store']);
    Route::get('/display', [CoursesController::class, 'index']);

});


