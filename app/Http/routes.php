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

Route::get('csrf', function() {
	return Session::token();
});

Route::group(['prefix' => 'documents'], function() {
	get('','DocumentsController@findMultiResult');

	get('/{id}','DocumentsController@findSingleResult');

	post('','DocumentsController@writeDocument');

	post('/{id}','DocumentsController@checkUser');

	post('/rewrite/{id}','DocumentsController@reWriteDocument');

	delete('/{id}','DocumentsController@deleteDocument');

	put('/{id}','DocumentsController@modificationDocument');
});

Route::group(['prefix'=>'emails'],function() {

	get('','EmailsController@findMultiResult');

	get('/{id}','EmailsController@findSingleResult');

	post('','EmailsController@sendEmail');

});
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
