<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'Auth\AuthController@getIndex');
Route::controller('auth', 'Auth\AuthController');
Route::controller('facebook', 'FacebookController');
// Route::get('facebook/fblogin', 'FacebookController@getFblogin');
// Route::get('facebook/fbcallback', 'FacebookController@getFbcallback');



Route::group(['middleware' => 'auth'], function () {
    Route::controllers([
		'accountdata'	=>	'AccountdataController'
	]);
});
