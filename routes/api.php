<?php

use Illuminate\Http\Request;

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

Route::apiResource('movies', 'MovieController');
Route::apiResource('raters', 'RaterController');
Route::apiResource('comments', 'CommentController');

Route::middleware('api')->namespace('Auth')->prefix('auth')->group(function() {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::middleware('jwt.auth')->group(function() {
    Route::apiResource('movies', 'MovieController');
    Route::apiResource('comments', 'CommentController');
    Route::apiResource('raters', 'RaterController');
});

Route::middleware(['jwt.auth', 'can:manage-movies'])->group(function() {

    Route::apiResource('movies', 'MovieController')->only([
        'store',
        'update',
        'destroy'
    ]);

});

Route::middleware(['jwt.auth', 'can:manage-raters'])->group(function() {

    Route::apiResource('raters', 'RaterController')->only([
        'store',
        'update',
        'destroy'
    ]);

});

Route::middleware(['jwt.auth', 'can:manage-comments'])->group(function() {

    Route::apiResource('comments', 'CommentController')->only([
        'store',
        'update',
        'destroy'
    ]);

});

Route::middleware(['jwt.auth', 'can:view-movies'])->group(function() {

    Route::apiResource('movies', 'MovieController')->only([
        'index',
        'show',
    ]);

});

Route::middleware(['jwt.auth', 'can:view-comments'])->group(function() {

    Route::apiResource('comments', 'CommentController')->only([
        'index',
        'show',
    ]);
});