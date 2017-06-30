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
Route::get('dashboard_correspondente',['as' => 'dashboard_correspondente', 'uses' => 'PagesController@dashboard_correspondente']);
Route::get('dashboard_cliente',['as' => 'dashboard_cliente', 'uses' => 'PagesController@dashboard_cliente']);
Route::get('dashboard',['as' => 'pages.dashboard', 'uses' => 'PagesController@dashboard']);
Route::get('financeiro',['as' => 'pages.financeiro', 'uses' => 'PagamentosController@index']);

// get correspondentes map
Route::get('correspondentes/get',['as' => 'correspondentes.get', 'uses' => 'CorrespondentesController@get']);

Route::resource('users','UsersController');
Route::resource('clientes','ClientesController');
Route::resource('comarcas','ComarcasController');
Route::resource('correspondentes','CorrespondentesController');
Route::resource('diligencias','DiligenciasController');
Route::resource('emails','EmailsController');
Route::resource('files','FilesController');
Route::resource('pagamentos','PagamentosController');
Route::resource('servicos','ServicosController');
Route::resource('sondagens','SondagensController');
Route::resource('statuses','StatusesController');
Route::resource('advogados','AdvogadosController');

// File upload
Route::get('/upload', 'FilesController@uploadForm');
Route::post('/upload', 'FilesController@uploadSubmit');

// Acoes
Route::get('diligencias/aceitar/{id}',['as' => 'diligencias.aceitar', 'uses' => 'DiligenciasController@aceitar']);
Route::get('diligencias/checkin/{id}',['as' => 'diligencias.checkin', 'uses' => 'DiligenciasController@checkin']);
Route::get('diligencias/concluir/{id}',['as' => 'diligencias.concluir', 'uses' => 'DiligenciasController@concluir']);
Route::get('diligencias/resolver/{id}',['as' => 'diligencias.resolver', 'uses' => 'DiligenciasController@resolver']);
Route::get('diligencias/aprovar/{id}',['as' => 'diligencias.aprovar', 'uses' => 'DiligenciasController@aprovar']);
Route::get('diligencias/devolver/{id}',['as' => 'diligencias.devolver', 'uses' => 'DiligenciasController@devolver']);
Route::get('diligencias/selecionarCorrespondente/{c_id?}/{d_id?}',['as' => 'diligencias.selecionarCorrespondente', 'uses' => 'DiligenciasController@selecionarCorrespondente']);

Route::get('status/getStatusesPercentages',['as' => 'status.getStatusesPercentages', 'uses' => 'StatusesController@getStatusesPercentages']);
Route::get('getComarcas',['as' => 'getComarcas', 'uses' => 'ComarcasController@getComarcas']);
Route::get('pages/setup',['as' => 'pages.setup', 'uses' => 'PagesController@setup']);

// Correspondentes editar comarcas
Route::get('correspondentes/comarcas/{id}',['as' => 'correspondentes.comarcas', 'uses' => 'CorrespondentesController@comarcas']);
Route::post('correspondentes/comarcas',['as' => 'correspondentes.comarcasStore', 'uses' => 'CorrespondentesController@comarcasStore']);
Route::post('correspondentes/comarcasUpdate',['as' => 'correspondentes.comarcasUpdate', 'uses' => 'CorrespondentesController@comarcasUpdate']);

Auth::routes();


