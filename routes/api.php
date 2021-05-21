<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {

    Route::prefix('order')->group(function () {
        Route::get('{id}', [\App\Http\Controllers\APIController::class, 'getOrderDetails']);
        Route::post('/', [\App\Http\Controllers\APIController::class, 'postNewOrder']);
        Route::post('progress', [\App\Http\Controllers\APIController::class, 'updateProgressOrder']);
        Route::post('progress', [\App\Http\Controllers\APIController::class, 'updateProgressOrder']);

        Route::post('payment', [\App\Http\Controllers\APIController::class, 'postPayments']);
        Route::post('payment/update', [\App\Http\Controllers\APIController::class, 'updatePayments']);
    });

});
