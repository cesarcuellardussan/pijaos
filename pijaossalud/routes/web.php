<?php

use Illuminate\Support\Facades\Route;

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
    return view('home');
})->name('home');

Route::group(["prefix" => "hospitales"], function () {
    Route::get('/','HospitalController@index')->name('hospitales.index');
    Route::post('/','HospitalController@store')->name('hospitales.store');
    Route::put('/{cod_hospital}','HospitalController@update')->name('hospitales.update');
    Route::delete('/{cod_hospital}','HospitalController@destroy')->name('hospitales.destroy');
    Route::get('/{cod_hospital}/edit','HospitalController@edit')->name('hospitales.edit');
});

Route::group(["prefix" => "pacientes"], function () {
    Route::get('/','PacienteController@index')->name('pacientes.index');
    Route::post('/','PacienteController@store')->name('pacientes.store');
    Route::put('/{no_documento}','PacienteController@update')->name('pacientes.update');
    Route::delete('/{no_documento}','PacienteController@destroy')->name('pacientes.destroy');
    Route::get('/{no_documento}/edit','PacienteController@edit')->name('pacientes.edit');
});

Route::group(["prefix" => "gestiones"], function () {
    Route::get('/','GestionHospitalariaController@index')->name('gestiones.index');
    Route::post('/','GestionHospitalariaController@store')->name('gestiones.store');
    Route::get('/create','GestionHospitalariaController@create')->name('gestiones.create');
    Route::put('/{id_hospitalizacion}','GestionHospitalariaController@update')->name('gestiones.update');
    Route::delete('/{id_hospitalizacion}','GestionHospitalariaController@destroy')->name('gestiones.destroy');
    Route::get('/{id_hospitalizacion}/edit','GestionHospitalariaController@edit')->name('gestiones.edit');
});

Route::resource('photos', 'GestionHospitalariaController');
