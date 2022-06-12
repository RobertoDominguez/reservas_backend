<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SystemController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\OpenController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\VoucherController;


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

Route::post('/login',[UserController::class,'login']);
Route::post('/signup',[UserController::class,'signup']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/user/authenticated', [UserController::class, 'authenticated']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/logout_all', [UserController::class, 'logoutAll']);
    
    Route::prefix('user')->group(function () {
        Route::get('/',[UserController::class,'index']);
        Route::get('/{user}',[UserController::class,'show']);
        Route::post('/',[UserController::class,'store']);
        Route::put('/{user}',[UserController::class,'update']);
        Route::delete('/{user}',[UserController::class,'destroy']);
        Route::post('/restore',[UserController::class,'restore']);
    });

    Route::prefix('system')->group(function () {
        Route::get('/',[SystemController::class,'index']);
        Route::get('/{system}',[SystemController::class,'show']);
        Route::post('/',[SystemController::class,'store']);
        Route::put('/{system}',[SystemController::class,'update']);
        Route::delete('/{system}',[SystemController::class,'destroy']);
        Route::post('/restore',[SystemController::class,'restore']);
    });

    Route::prefix('store')->group(function () {
        Route::get('/',[StoreController::class,'index']);
        Route::get('/{store}',[StoreController::class,'show']);
        Route::post('/',[StoreController::class,'store']);
        Route::put('/{store}',[StoreController::class,'update']);
        Route::delete('/{store}',[StoreController::class,'destroy']);
        Route::post('/restore',[StoreController::class,'restore']);
    });

    Route::prefix('open')->group(function () {
        Route::get('/',[OpenController::class,'index']);
        Route::get('/{open}',[OpenController::class,'show']);
        Route::post('/',[OpenController::class,'store']);
        Route::put('/{open}',[OpenController::class,'update']);
        Route::delete('/{open}',[OpenController::class,'destroy']);
        Route::post('/restore',[OpenController::class,'restore']);
    });

    Route::prefix('carousel')->group(function () {
        Route::get('/',[CarouselController::class,'index']);
        Route::get('/{carousel}',[CarouselController::class,'show']);
        Route::post('/',[CarouselController::class,'store']);
        Route::put('/{carousel}',[CarouselController::class,'update']);
        Route::delete('/{carousel}',[CarouselController::class,'destroy']);
        Route::post('/restore',[CarouselController::class,'restore']);
    });

    Route::prefix('service')->group(function () {
        Route::get('/',[ServiceController::class,'index']);
        Route::get('/{service}',[ServiceController::class,'show']);
        Route::post('/',[ServiceController::class,'store']);
        Route::put('/{service}',[ServiceController::class,'update']);
        Route::delete('/{service}',[ServiceController::class,'destroy']);
        Route::post('/restore',[ServiceController::class,'restore']);
    });

    Route::prefix('product')->group(function () {
        Route::get('/',[ProductController::class,'index']);
        Route::get('/{product}',[ProductController::class,'show']);
        Route::post('/',[ProductController::class,'store']);
        Route::put('/{product}',[ProductController::class,'update']);
        Route::delete('/{product}',[ProductController::class,'destroy']);
        Route::post('/restore',[ProductController::class,'restore']);
    });

    Route::prefix('reservation')->group(function () {
        Route::get('/',[ReservationController::class,'index']);
        Route::get('/{reservation}',[ReservationController::class,'show']);
        Route::post('/',[ReservationController::class,'store']);
        Route::put('/{reservation}',[ReservationController::class,'update']);
        Route::delete('/{reservation}',[ReservationController::class,'destroy']);
        Route::post('/restore',[ReservationController::class,'restore']);
    });

    Route::prefix('account')->group(function () {
        Route::get('/',[AccountController::class,'index']);
        Route::get('/{account}',[AccountController::class,'show']);
        Route::post('/',[AccountController::class,'store']);
        Route::put('/{account}',[AccountController::class,'update']);
        Route::delete('/{account}',[AccountController::class,'destroy']);
        Route::post('/restore',[AccountController::class,'restore']);
    });

    Route::prefix('voucher')->group(function () {
        Route::get('/',[VoucherController::class,'index']);
        Route::get('/{voucher}',[VoucherController::class,'show']);
        Route::post('/',[VoucherController::class,'store']);
        Route::put('/{voucher}',[VoucherController::class,'update']);
        Route::delete('/{voucher}',[VoucherController::class,'destroy']);
        Route::post('/restore',[VoucherController::class,'restore']);
    });



    //Muestra de como usar las habilities
    Route::post('/test1', function () {
        return 'works';
    })->middleware('ability:user_store,administrator');
});

//php artisan serve --host=192.168.0.3 --port=8001