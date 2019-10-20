<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function(){
	Route::prefix('product')->group(function(){
		Route::get('/','ProductController@index')->name('product.index');
		Route::get('create','ProductController@create')->name('product.create');
		Route::get('edit','ProductController@edit')->name('product.edit');
		Route::post('store','ProductController@store')->name('product.store');
		Route::put('update','ProductController@update')->name('product.update');
		Route::delete('delete','ProductController@delete')->name('product.delete');
	});
});
