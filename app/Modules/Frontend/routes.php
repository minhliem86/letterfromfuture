<?php

Route::group(['namespace'=>'App\Modules\Frontend\Controllers'],function(){

	Route::get('import-data',['as'=>'getImportdata','uses'=>'ImportdataController@getImport']);
	Route::post('import-data',['as'=>'postImportdata','uses'=>'ImportdataController@postImport']);

	Route::get('/thu-tu-tuong-lai/{slug?}',['as'=>'homepage','uses'=>'HomeController@getBaiduthi']);
	Route::post('/ajaxShowmoreBaiThi',['as'=>'frontend.ajaxShowmoreBaiThi','uses'=>'HomeController@ajaxShowmoreBaiThi']);
	Route::post('/ajaxShowmoreTop50',['as'=>'frontend.ajaxShowmoreTop50','uses'=>'HomeController@ajaxShowmoreTop50']);

	Route::get('/bai-viet/{id}',['as'=>'frontend.BaivietDetail','uses'=>'HomeController@getBaivietDetail'])->where(['id','[a-zA-Z0-9./\-]']);


	Route::get('/dang-nhap',['as'=>'frontend.getLogin','uses'=>'StudentController@getLogin']);
	Route::post('/checkLogin',['as'=>'frontend.checkLogin','uses'=>'StudentController@checkLogin']);
	Route::post('/login',['as'=>'frontend.postLogin','uses'=>'StudentController@postLogin']);

	Route::get('/buc-thu-tu-tuong-lai',['as'=>'frontend.getLetter','uses'=>'StudentController@getLetter']);
	Route::post('write-letter-ajax',['as'=>'frontend.ajaxLetter','uses'=>'StudentController@ajaxLetter']);
	// Route::post('/write-letter',['as'=>'frontend.postLetter','uses'=>'StudentController@postLetter']);

	Route::post('/ajaxImgFB',['as'=>'frontend.AjaxImg','uses'=>'StudentController@AjaxImg']);

	Route::post('/ajaxOrder',['as'=>'frontend.AjaxOrder','uses'=>'StudentController@AjaxOrder']);

	Route::get('/done',['as'=>'frontend.Done', 'uses'=>'StudentController@getDone']);

	Route::get('/test',['uses'=>'HomeController@test']);

	// FACEBOOK SDK VIA LARAVEL
	Route::get('/letter',['as'=>'fb.getLetter','uses'=>'FacebookController@getLetter']);

	Route::get('/letter/process',['as'=>'fb.postLetter','uses'=>'FacebookController@postLetter'])

});
