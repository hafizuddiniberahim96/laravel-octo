<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PerformerController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\TimeslotController;
use App\Http\Controllers\RatingController;

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
                Route::post('/add_movie','add')->name('post.movies.add');
                Route::get('/new_movies','new_movie')->name('get.movies.new');
            });

        Route::controller(GenreController::class)
        ->prefix('/genres')
        ->group(function () {
            Route::get('/genre','get_movie')->name('get.genres.get_movie');
        });

        Route::controller(PerformerController::class)
        ->prefix('/performers')
        ->group(function () {
            Route::get('/search_performer','get_movie')->name('get.perfomers.get_movie');
        });

        Route::controller(TheaterController::class)
        ->prefix('/theaters')
        ->group(function () {
            Route::post('/add','add')->name('post.theaters.add.theaters');
            Route::post('/add_room','add_rooms')->name('post.theaters.add.rooms');
            Route::get('/specific_movie_theater','get_movie')->name('get.theaters.get_movie');
            Route::post('/timeslot','add_movie')->name('post.theaters.timeslot');
        });

        Route::controller(TimeslotController::class)
        ->prefix('/timeslots')
        ->group(function () {
            Route::get('/timeslot','get_movie')->name('get.timeslot.get_movie');
        });
        
        Route::controller(RatingController::class)
        ->prefix('/ratings')
        ->group(function () {
            Route::post('/give_rating','add')->name('post.rating.give_rating');
        });
    });

});






