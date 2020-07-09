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


    // Route::get('show', 'Apis\UserController@index');
    // Route::get('show/{user}', 'Apis\UserController@show');
    Route::put('update/{user}', 'Apis\UserController@update');
    Route::delete('delete/{user}', 'Apis\UserController@delete');
    // Route::any('errors', 'Apis\UserController@errors');
});

Route::group(['prefix' => 'categories'], function(){

    Route::get('show', 'Apis\CategoryController@index');
    Route::get('list', 'Apis\CategoryController@list');
    Route::get('show/{category}', 'Apis\CategoryController@show');
    Route::get('show/{category}/products', 'Apis\CategoryController@products');
    Route::post('store', 'Apis\CategoryController@store');
    Route::put('update/{category}', 'Apis\CategoryController@update');
    Route::delete('delete/{category}', 'Apis\CategoryController@delete');
    Route::any('errors', 'Apis\CategoryController@errors');

});

Route::group(['prefix' => 'products'], function(){

    Route::get('show', 'Apis\ProductController@index');
    Route::get('show/{product}', 'Apis\ProductController@show');
    Route::post('store', 'Apis\ProductController@store');
    Route::put('update/{product}', 'Apis\ProductController@update');
    Route::delete('delete/{product}', 'Apis\ProductController@delete');
    Route::any('errors', 'Apis\ProductController@errors');

});
