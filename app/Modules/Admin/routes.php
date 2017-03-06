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

	Route::group(['middleware'=>'loginpermission'],function(){
		Route::get('dashboard',['as'=>'admin','uses'=>'AdminController@index']);

		// ADD MORE USER
		Route::get('create-user',['as'=>'admin.getCreateUser','uses'=>'AdminController@getCreateUser']);
		Route::post('create-user',['as'=>'admin.postCreateUser','uses'=>'AdminController@postCreateUser']);
		/*CHANGE PASS*/
		Route::get('password',['as'=>'admin.getChangePass','uses'=>'AdminController@getChangePass']);
		Route::post('password',['as'=>'admin.postChangePass','uses'=>'AdminController@postChangePass']);
	});

	Route::get('listTeacher',['as'=>'admin.getTeacher','uses'=>'AdminController@getTeacher']);
	Route::delete('deleteTeacher/{id}',['as'=>'admin.deleteDeleteTeacher','uses'=>'AdminController@postDeleteTeacher'])->where(['id'=>'[a-zA-Z0-9./\-]+']);

	Route::get('postDetail/{id}',['as'=>'admin.getPostDetail','uses'=>'PostController@getDetail']);


});
