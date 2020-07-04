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

Route::group(['prefix' => 'users'], function(){
    Route::get('list', 'Apis\UserController@index')->name('list_users');
    Route::post('store', 'Apis\UserController@store')->name('store_users');
    Route::post('update', 'Apis\UserController@edit')->name('edit_users');
    Route::post('delete', 'Apis\UserController@delete')->name('delete_users');
});

Route::group(['prefix' => 'categories'], function(){
    Route::get('list', 'Apis\CategoryController@index')->name('list_categories');
    Route::post('store', 'Apis\CategoryController@store')->name('store_categories');
    Route::post('update', 'Apis\CategoryController@edit')->name('edit_categories');
    Route::post('delete', 'Apis\CategoryController@delete')->name('delete_categories');
});

Route::group(['prefix' => 'products'], function(){
    Route::get('list', 'Apis\ProductController@index')->name('list_products');
    Route::post('store', 'Apis\ProductController@store')->name('store_products');
    Route::post('update', 'Apis\ProductController@edit')->name('edit_products');
    Route::post('delete', 'Apis\ProductController@delete')->name('delete_products');
});
