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

Route::get('/', function () {
    return view('welcome');
});
Route::get('index','TextController@index');

Route::any('/index/create','TextController@create');

Route::any('/index/store','TextController@store');
Route::any('/index/lists','TextController@lists');
Route::any('/index/delete/{id}','TextController@delete');
Route::any('/index/edit/{id}','TextController@edit');
Route::any('/index/update/{id}','TextController@update');

Route::get('lian','TextController@lian');


Route::any('/reg/reg','RegController@reg');
Route::any('/reg/regdo','RegController@regdo');
Route::any('/reg/login','RegController@login');
Route::any('/reg/logindo','RegController@logindo');