<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
	Route::get('/', function () {
	    return view('welcome');
	});


	// Auth routes
	Route::group(['namespace' => 'Auth'], function() {
		Route::get('register/check-email', 'AuthController@getCheckEmail');
		Route::get('register/check-sduid', 'AuthController@getCheckSduid');
		Route::get('register', 'AuthController@getRegister');
		Route::post('register', 'AuthController@postRegister');
		Route::get('login', 'AuthController@getLogin');
		Route::post('login', 'AuthController@postLogin');
		Route::get('logout', 'AuthController@logout');

		// Password reset link request routes...
		Route::get('password/email', 'PasswordController@getEmail');
		Route::post('password/email', 'PasswordController@postEmail');

		// Password reset routes...
		Route::get('password/reset/{token}', 'PasswordController@getReset');
		Route::post('password/reset', 'PasswordController@postReset');
	});


	Route::group(['middleware' => 'auth',], function () {
		// Manage routes
		Route::group(['namespace' => 'Manage'], function () {
			Route::get('dashboard', function() { return view('manage.dashboard'); });
			Route::get('request', 'UserRequestController@index');
			Route::get('material/requisition', 'MaterialController@request');
			Route::get('equipment/borrow', 'EquipmentController@request');

			Route::resource('material', 'MaterialController');
			Route::resource('equipment', 'EquipmentController');
		});

		
		// Account routes
		Route::group(['prefix' => 'account', 'namespace' => 'Account'], function () {
			Route::get('/', function() { return redirect('account/profile'); });

			Route::get('check-email', 'ChangeEmailController@getCheckEmail');
			Route::get('check-sduid', 'ProfileController@getCheckSduid');

			Route::resource('profile', 'ProfileController');
			Route::resource('change-password', 'ChangePasswordController');
			Route::resource('change-email', 'ChangeEmailController');
		});

		
		// Admin routes
		Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {

			Route::get('/', function() { return redirect('admin/request'); });
			Route::get('report/{id}', 'ReportController@show');
			Route::get('report/{id}/{format}', 'ReportController@show');
			Route::post('report', 'ReportController@show');
			Route::post('report/{format}', 'ReportController@show');

			Route::resource('request', 'RequestController');
			Route::resource('material', 'MaterialController');
			Route::resource('equipment', 'EquipmentController');
			Route::resource('category', 'CategoryController');
		});
	});
});
