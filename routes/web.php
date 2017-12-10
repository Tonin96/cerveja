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

//Route::get('/', ['as' => 'home', 'uses' => 'ConceitoController@index']);

Auth::routes();

Route::group(['prefix' => '/', 'middleware' => ['dadosCompletos']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
});


Route::group(['prefix' => 'conceito', 'middleware' => ['admin']], function () {
    Route::get('/', ['as' => 'conceito.index', 'uses' => 'ConceitoController@index']);

    Route::post('/store', ['as' => 'conceito.store', 'uses' => 'ConceitoController@store']);
});

Route::group(['prefix' => 'cerveja', 'middleware' => ['admin']], function () {
    Route::get('/', ['as' => 'cerveja.index', 'uses' => 'CervejaController@index']);

    Route::post('/store', ['as' => 'cerveja.store', 'uses' => 'CervejaController@store']);
    Route::group(['prefix' => 'conceitos'], function () {
        Route::get('/{cerveja_id}', ['as' => 'cerveja_conceito.index', 'uses' => 'CervejaController@indexConceitos']);
        Route::post('/store', ['as' => 'cerveja_conceito.store', 'uses' => 'CervejaController@storeConceito']);
    });

});

Route::group(['prefix' => 'pessoa'], function () {
    Route::get('/', ['as' => 'pessoa.index', 'uses' => 'PessoaController@index']);

    Route::get('/meusDados', ['as' => 'pessoa.meusDados', 'uses' => 'PessoaController@meusDados']);
    Route::post('/salvarDados', ['as' => 'pessoa.salvar_dados', 'uses' => 'PessoaController@salvarDados']);

    Route::group(['prefix' => 'conceitos'], function () {
        Route::get('/{pessoa_id}', ['as' => 'pessoa.indexConceitos', 'uses' => 'PessoaController@indexConceitos']);
        Route::post('/store', ['as' => 'pessoa.storeConceito', 'uses' => 'PessoaController@storeConceito']);
    });
});

Route::group(['prefix' => 'mapa', 'middleware' => ['admin', 'dadosCompletos']], function () {
    Route::get('/', ['as' => 'mapa.index', 'uses' => 'MapaController@index']);

    Route::post('/store', ['as' => 'mapa.store', 'uses' => 'MapaController@store']);
    Route::get('/{id}', ['as' => 'mapa.indexConceito', 'uses' => 'MapaController@indexConceitos']);

    Route::group(['prefix' => 'conceitos'], function () {
        Route::post('/store', ['as' => 'mapa.storeConceito', 'uses' => 'MapaController@storeConceito']);
    });
});

Route::group(['prefix' => 'google'], function () {
    Route::post('getEstalecimentosByPosition/', ['as' => 'google.estabelecimentos', 'uses' => 'GoogleController@getEstalecimentosByPosition']);
});

Route::group(['prefix' => 'auth'], function () {
    Route::get('{provider}', 'Auth\AuthController@redirectToProvider');
    Route::get('{provider}/callback', 'Auth\AuthController@handleProviderCallback');
});