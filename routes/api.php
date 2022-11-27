<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(array('middleware' => ['custom_auth']), function ()
// {
//     Route::apiResource('token', TokenController::class);
//     Route::post('/token/topup', [TokenController::class, 'store']);
// });
// Route::get('/register',[AuthController::class,'register'])->name('user.register');

Route::middleware('custom_auth')
        ->prefix('/v1')->group(function () {

    Route::controller(AuthController::class)
        ->group(function () {
            Route::get('/register','register')->name('user.register');
            Route::post('/login','login')->name('user.login');
        });
    
    
    Route::middleware('auth:sanctum')
            ->group(function () {
        Route::controller(MovieController::class)
            ->prefix('/movies')
            ->group(function () {
                Route::post('/add_movie','add')->name('movies.add');
            });
        

    });

});






