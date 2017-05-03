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


Route::get('/',['as' => 'home', 'uses' => 'PagesController@home']);
Route::get('dashboard',['as' => 'pages.dashboard', 'uses' => 'PagesController@dashboard']);
Route::get('financeiro',['as' => 'pages.financeiro', 'uses' => 'PagesController@financeiro']);

Route::resource('users','UsersController');
Route::resource('advogados','UsersController');
Route::resource('clientes','UsersController');
Route::resource('comarcas','UsersController');
Route::resource('correspondentes','UsersController');
Route::resource('diligencias','UsersController');
Route::resource('emails','UsersController');
Route::resource('files','UsersController');
Route::resource('pagamentos','UsersController');
Route::resource('servicos','UsersController');
Route::resource('sondagens','UsersController');
Route::resource('statuses','UsersController');
Route::resource('tipos','UsersController');

Auth::routes();


