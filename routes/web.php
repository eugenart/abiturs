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

Route::get('/infoblock', function () {
    return view('structure.infoblock');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
