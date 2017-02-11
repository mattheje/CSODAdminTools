<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::any('/', ['as' => 'index', 'uses' => 'IndexController@index']);
Route::any('index/maincontent', ['as' => 'maincontent', 'uses' => 'IndexController@maincontent']);
Route::any('index/menu', ['as' => 'menu', 'uses' => 'IndexController@menu']);
Route::any('construction', ['as' => 'construction', 'uses' => 'IndexController@construction']);
Route::any('index/dashboard/{type?}', ['as' => 'dashboard', 'uses' => 'IndexController@dashboard']);

Route::any('login', ['as' => 'login', 'uses' => 'LoginController@index']);
Route::any('login/login', ['as' => 'loginlogin', 'uses' => 'LoginController@login']);
Route::any('login/logout', ['as' => 'loginlogout', 'uses' => 'LoginController@logout']);

Route::any('user', ['as' => 'userindex', 'uses' => 'UserController@index']);

Route::any('lonum', ['as' => 'step1', 'uses' => 'LoNumController@step1']);
Route::any('lonum/step1', ['as' => 'step1', 'uses' => 'LoNumController@step1']);
Route::any('lonum/step2n', ['as' => 'step2n', 'uses' => 'LoNumController@step2n']);
Route::any('lonum/step3n', ['as' => 'step3n', 'uses' => 'LoNumController@step3n']);
Route::any('lonum/step4n', ['as' => 'step4n', 'uses' => 'LoNumController@step4n']);
Route::any('lonum/step2m', ['as' => 'step2m', 'uses' => 'LoNumController@step2m']);
Route::any('lonum/step2v', ['as' => 'step2v', 'uses' => 'LoNumController@step2v']);

Route::any('lonum/fetchmylos', ['as' => 'fetchmylos', 'uses' => 'LoNumController@fetchMyReservedLOs']);
Route::any('lonum/fetchmypublos', ['as' => 'fetchmypublos', 'uses' => 'LoNumController@fetchMyPublishedLOs']);
Route::any('lonum/fetchotherslos', ['as' => 'fetchotherlos', 'uses' => 'LoNumController@fetchOthersReservedLOs']);
Route::any('lonum/searchcourseforvers', ['as' => 'searchcourseforvers', 'uses' => 'LoNumController@searchCourseDataForVersioning']);
Route::any('lonum/getnextcrsversion', ['as' => 'getnextcrsversion', 'uses' => 'LoNumController@getNextCourseVersion']);

Route::any('lonum/step5', ['as' => 'step5', 'uses' => 'LoNumController@step5']);

