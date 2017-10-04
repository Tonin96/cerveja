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

Route::get('/', ['as' => 'home', 'uses' => 'ConceitoController@index']);

Route::group(['prefix' => 'conceito'], function () {
    Route::get('/', ['as' => 'conceito.index', 'uses' => 'ConceitoController@index']);

    Route::post('/store', ['as' => 'conceito.store', 'uses' => 'ConceitoController@store']);
});

Route::group(['prefix' => 'mapa'], function () {
    Route::get('/', ['as' => 'mapa.index', 'uses' => 'MapaController@index']);

    Route::post('/store', ['as' => 'mapa.store', 'uses' => 'MapaController@store']);
    Route::get('/{id}', ['as' => 'mapa.conceitos', 'uses' => 'MapaController@getConceitosByMapa']);

    Route::group(['prefix' => 'conceitos'], function () {
        Route::post('/store', ['as' => 'mapa_conceito.store', 'uses' => 'MapaConceitoController@store']);
    });

});
Route::group(['prefix' => 'auth'], function () {
    Route::get('{provider}', 'Auth\AuthController@redirectToProvider');
    Route::get('{provider}/callback', 'Auth\AuthController@handleProviderCallback');
});


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
