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

Route::any('index/content', ['as' => 'content', 'uses' => 'IndexController@content']);

Route::any('login', ['as' => 'login', 'uses' => 'LoginController@index']);
Route::any('login/login', ['as' => 'loginlogin', 'uses' => 'LoginController@login']);
Route::any('login/logout', ['as' => 'loginlogout', 'uses' => 'LoginController@logout']);

Route::any('user', ['as' => 'userindex', 'uses' => 'UserController@index']);
