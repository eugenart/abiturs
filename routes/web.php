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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('structure.index');
});

Route::get('/infoblocks', 'InfoblockController@index')->name('infoblock.index');
Route::post('/infoblock', 'InfoblockController@store')->name('infoblock.store');
Route::put('/infoblock/{id}', 'InfoblockController@update')->name('infoblock.update');
Route::delete('/infoblock/{id}', 'InfoblockController@destroy')->name('infoblock.destroy');

Route::get('/section', 'SectionController@index')->name('section.index');
Route::post('/section', 'SectionController@store')->name('section.store');
Route::put('/section/{id}', 'SectionController@update')->name('section.update');
Route::delete('/section/{id}', 'SectionController@destroy')->name('section.destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
