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
		Route::get('edit/{id}','ProductController@edit')->name('product.edit');
		Route::post('store','ProductController@store')->name('product.store');
		Route::post('update/{id}','ProductController@update')->name('product.update');
		Route::delete('delete/{id}','ProductController@destroy')->name('product.delete');
	});
	Route::prefix('payment')->group(function(){
		Route::get('/','PaymentController@index')->name('payment.index');
		Route::get('decline/{id}','PaymentController@decline')->name('payment.decline');
		Route::get('accept/{id}','PaymentController@accept')->name('payment.accept');
		Route::get('pending/{id}','PaymentController@pending')->name('payment.pending');
		Route::delete('delete/{id}','PaymentController@destroy')->name('payment.delete');
	});
	Route::prefix('role')->group(function(){
		Route::get('/','RoleController@index')->name('role.index');
		Route::get('create','RoleController@create')->name('role.create');
		Route::get('edit/{id}','RoleController@edit')->name('role.edit');
		Route::post('store','RoleController@store')->name('role.store');
		Route::post('update/{id}','RoleController@update')->name('role.update');
		Route::delete('delete/{id}','RoleController@destroy')->name('role.delete');
	});
	Route::prefix('customer')->group(function(){
		Route::get('/','CustomerController@index')->name('customer.index');
		Route::get('create','CustomerController@create')->name('customer.create');
		Route::get('edit/{id}','CustomerController@edit')->name('customer.edit');
		Route::get('new','CustomerController@new')->name('customer.new');
		Route::post('store','CustomerController@store')->name('customer.store');
		Route::post('nstore','CustomerController@newstore')->name('customer.nstore');
		Route::post('update/{id}','CustomerController@update')->name('customer.update');
		Route::get('disable/{id}','CustomerController@disable')->name('customer.disable');
		Route::get('active/{id}','CustomerController@active')->name('customer.active');
		Route::get('expired/{id}','CustomerController@expired')->name('customer.expired');
		Route::delete('delete/{id}','CustomerController@destroy')->name('customer.delete');
	});
	Route::prefix('user')->group(function(){
		Route::get('/','UserController@index')->name('user.index');
		Route::get('create','UserController@create')->name('user.create');
		Route::get('edit/{id}','UserController@edit')->name('user.edit');
		Route::post('store','UserController@store')->name('user.store');
		Route::post('update/{id}','UserController@update')->name('user.update');
		Route::delete('delete/{id}','UserController@destroy')->name('user.delete');
	});
});
