<?php

Route::group(['namespace'=>'App\Modules\Frontend\Controllers'],function(){
	Route::get('import-data',['as'=>'getImportdata','uses'=>'ImportdataController@getImport']);
	Route::post('import-data',['as'=>'postImportdata','uses'=>'ImportdataController@postImport']);

	Route::get('/',['as'=>'homepage','uses'=>'StudentController@getIndex']);
	Route::get('/login',['as'=>'frontend.getLogin','uses'=>'StudentController@getLogin']);
	Route::post('/checkLogin',['as'=>'frontend.checkLogin','uses'=>'StudentController@checkLogin']);
	Route::post('/login',['as'=>'frontend.postLogin','uses'=>'StudentController@postLogin']);

	Route::get('/write-letter',['as'=>'frontend.getLetter','uses'=>'StudentController@getLetter']);
	Route::post('write-letter-ajax',['as'=>'frontend.ajaxLetter','uses'=>'StudentController@ajaxLetter']);
	Route::post('/write-letter',['as'=>'frontend.postLetter','uses'=>'StudentController@postLetter']);

});
