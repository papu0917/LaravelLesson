<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {

    Route::get('todo/create', 'Admin\TodoController@add');
    Route::post('todo/create', 'Admin\TodoController@create');
    Route::get('todo', 'Admin\TodoController@index');
    Route::get('todo/edit', 'Admin\TodoController@edit');
    Route::post('todo/edit', 'Admin\TodoController@update');
    Route::get('todo/delete', 'Admin\TodoController@delete');
    Route::get('todo/complete', 'Admin\TodoController@complete');
    Route::get('todo/completed', 'Admin\TodoController@completed');
    Route::get('todo/uncomplete', 'Admin\TodoController@uncomplete');
    // Route::get('todo/favorite', 'Admin\TodoController@favorite');
    Route::get('todo/favorites', 'Admin\TodoController@favorites');
    Route::get('todo/unfavorites', 'Admin\TodoController@unfavorites');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::get('category/create', 'Admin\CategoryController@add');
    Route::post('category/create', 'Admin\CategoryController@create');
    Route::get('category', 'Admin\CategoryController@index');
    Route::get('category/edit', 'Admin\CategoryController@edit');
    Route::post('category/edit', 'Admin\CategoryController@update');
    Route::get('category/delete', 'Admin\CategoryController@delete');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::get('tag/create', 'Admin\TagController@add');
    Route::post('tag/create', 'Admin\TagController@create');
    Route::get('tag', 'Admin\TagController@index');
    Route::get('tag/edit', 'Admin\TagController@edit');
    Route::post('tag/edit', 'Admin\TagController@update');
    Route::get('tag/delete', 'Admin\TagController@delete');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
