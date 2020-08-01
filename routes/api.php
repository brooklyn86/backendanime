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
Route::group(['prefix' => 'v1', 'namespace' => 'Admin'], function () {
	Route::get('animes/lancamento', ['as' => 'anime.lancamento', 'uses' => 'AnimeController@listLancamento']);
	Route::get('animes/notImage', ['as' => 'anime.lancamento', 'uses' => 'AnimeController@getAnimesImage']);

	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
