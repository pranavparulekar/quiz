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

Route::get('login', 'UserController@view_login');
Route::post('login', 'UserController@do_validation');
Route::get('score/user/{id}', 'UserController@get_score');

Route::group(['middleware' => ['user.auth']], function () {
	Route::get('/', 'UserController@view_login');
	Route::get('logout', 'UserController@logout');

	Route::get('question', 'QuestionController@show');
	Route::post('submit', 'QuestionController@show_result');

});



