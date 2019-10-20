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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function(){
	Route::post('login', 'Api\AuthController@login');
	Route::post('register', 'Api\AuthController@register');
	Route::group(['middleware' => 'auth:api'], function(){
		Route::post('getUser', 'Api\AuthController@getUser');
		Route::post('logout', 'Api\AuthController@logout');
	});

	Route::prefix('user')->group(function(){
        Route::get('', 'API\UserController@index');
        Route::post('create','API\UserController@register');
        Route::get('{ID}','API\UserController@single');
        Route::post('update','API\UserController@update');
        Route::delete('delete','API\UserController@delete');
        Route::post('addRole','API\UserController@addRole');
        Route::delete('deleteRole','API\UserController@deleteRole');
    });

    Route::prefix('role')->group(function(){
        Route::get('', 'API\RoleController@index');
        Route::get('{ID}','API\RoleController@single');
        Route::get('{ID}/menu','API\RoleController@menu');
        Route::get('{ID}/menu/find/{menu}','API\RoleController@findMenu');
        Route::post('create','API\RoleController@create');
        Route::post('update','API\RoleController@update');
        Route::delete('delete','API\RoleController@delete');
        Route::post('{ID}/menu/create','API\RoleController@menuInsert');
        Route::post('{ID}/menu/update','API\RoleController@menuUpdate');
        Route::delete('{ID}/menu/delete','API\RoleController@deleteMenu');
    });

    Route::prefix('application_portal')->group(function(){
        Route::get('', 'API\ApplicationPortalController@index');
        Route::get('{ID}','API\ApplicationPortalController@single');
        Route::post('create','API\ApplicationPortalController@create');
        Route::post('update','API\ApplicationPortalController@update');
        Route::delete('delete','API\ApplicationPortalController@delete');
    });

    Route::prefix('cloud')->group(function(){
        Route::get('index','API\CloudSettingController@index');
        Route::post('update','API\CloudSettingController@update');
    });
});