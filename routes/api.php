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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function() {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
});

Route::group(['middleware' => 'apiJwt'], function(){
    Route::post('logout', 'AuthController@logout');
});

Route::group(['prefix' => 'users'], function(){
    Route::post('register', 'Apis\UserController@register');
    Route::post('login', 'Apis\UserController@authenticate');
    Route::post('logout', 'Apis\UserController@logout');
    Route::get('open', 'Apis\CategoryController@open');

    Route::put('update/{user}', 'Apis\UserController@update');
    Route::delete('delete/{user}', 'Apis\UserController@delete');
});

Route::group(['prefix' => 'categories'], function(){

    Route::post('store', 'Apis\CategoryController@store');
    Route::put('update/{category}', 'Apis\CategoryController@update');
    Route::delete('delete/{category}', 'Apis\CategoryController@delete');
    Route::get('show', 'Apis\CategoryController@index');
    Route::get('show/{category}', 'Apis\CategoryController@show');
    Route::get('show/{category}/products', 'Apis\CategoryController@products');

});

Route::group(['prefix' => 'products'], function(){

    Route::post('store', 'Apis\ProductController@store');
    Route::put('update/{product}', 'Apis\ProductController@update');
    Route::delete('delete/{product}', 'Apis\ProductController@delete');
    Route::get('show-all', 'Apis\ProductController@index');
    Route::get('show/{product}', 'Apis\ProductController@show');

});
