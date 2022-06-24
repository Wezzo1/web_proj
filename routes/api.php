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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/getFilm', [\App\Http\Controllers\FilmsController::class, 'getFilm']);

Route::post('/Login', [\App\Http\Controllers\FilmsController::class, 'Login']);


Route::group(['middleware'=>'auth:api'],function() {
    Route::post('/newCategory', [\App\Http\Controllers\CategoryController::class, 'store']);
    Route::post('/newFilms', [\App\Http\Controllers\FilmsController::class, 'store']);
    Route::delete('/deleteCategory/{id}', [\App\Http\Controllers\CategoryController::class, 'delete']);
    Route::delete('/deleteFilms/{id}', [\App\Http\Controllers\FilmsController::class, 'delete']);
    Route::post('/categoryUpdate/{id}' , [\App\Http\Controllers\CategoryController::class , 'update']);
    Route::post('/FilmsUpdate/{id}' , [\App\Http\Controllers\FilmsController::class , 'update']);
    Route::get('/getCategory', [\App\Http\Controllers\CategoryController::class, 'getCategory']);
});



