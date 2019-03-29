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
    return view('structure.index');
});

Route::get('/infoblocks', 'InfoblockController@index')->name('infoblock.index');
Route::post('/infoblock', 'InfoblockController@store')->name('infoblock.store');
Route::delete('/infoblock/{id}', 'InfoblockController@destroy')->name('infoblock.destroy');
Route::put('/infoblock/{id}', 'InfoblockController@update')->name('infoblock.update');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
