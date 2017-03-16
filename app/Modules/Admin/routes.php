<?php

Route::group(['prefix'=>'admin','namespace'=>'App\Modules\Admin\Controllers'],function(){

	Route::get('test',function(){
		return 'test';
	});

	Route::get('login',['as'=>'admin.getlogin','uses'=>'Auth\AuthController@getLogin']);
	Route::post('login',['as'=>'admin.postLogin','uses'=>'Auth\AuthController@postLogin']);

	Route::get('register',['as'=>'admin.getRegister','uses'=>'Auth\AuthController@getRegister']);
	Route::post('register',['as'=>'admin.postRegister','uses'=>'Auth\AuthController@postRegister']);

	Route::get('sendEmailReset',['as'=>'admin.getSendEmailReset','uses'=>'Auth\PasswordController@getEmail']);
	Route::post('sendEmailReset',['as'=>'admin.postSendEmailReset','uses'=>'Auth\PasswordController@postEmail']);
	Route::get('resetPassword/{token?}',['as'=>'admin.getresetPassword','uses'=>'Auth\PasswordController@getReset']);
	Route::post('resetPassword',['as'=>'admin.postresetPassword','uses'=>'Auth\PasswordController@postReset']);

	Route::get('logout',['as'=>'admin.getLogout','uses'=>'Auth\AuthController@getLogout']);

	// ROLE
	// Route::resource('/role','RoleController',['only'=>['create','store']]);

	Route::group(['middleware'=>'loginpermission'],function(){
		Route::get('/dashboard',['as'=>'admin','uses'=>'DashboardController@getIndex']);

		Route::resource('/student','PostController');

		// USER MANAGMENT
		Route::get('/user',['as'=>'admin.user.getUser','uses'=>'AdminController@getUser']);
		Route::get('/user/create',['as'=>'admin.user.getCreateUser','uses'=>'AdminController@getCreateUser']);
		Route::post('/user/create',['as'=>'admin.user.postCreateUser','uses'=>'AdminController@postCreateUser']);

		Route::delete('/user/delete/{id}',['as'=>'admin.user.deleteUser','uses'=>'AdminController@deleteUser']);

		/*CHANGE PASS*/
		Route::get('password',['as'=>'admin.getChangePass','uses'=>'AdminController@getChangePass']);
		Route::post('password',['as'=>'admin.postChangePass','uses'=>'AdminController@postChangePass']);
	});


});
