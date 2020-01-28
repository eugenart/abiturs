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
Auth::routes();
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::redirect('/', '/admin/infoblocks');

    Route::get('/infoblocks', 'InfoblockController@index')->name('infoblock.index');
    Route::post('/infoblock', 'InfoblockController@store')->name('infoblock.store');
    Route::post('/infoblock/{id}', 'InfoblockController@update')->name('infoblock.update');
    Route::delete('/infoblock/{id}', 'InfoblockController@destroy')->name('infoblock.destroy');

    Route::get('/sections', 'SectionController@index')->name('section.index');
    Route::post('/section', 'SectionController@store')->name('section.store');
    Route::post('/section/{id}', 'SectionController@update')->name('section.update');
    Route::delete('/section/{id}', 'SectionController@destroy')->name('section.destroy');

    Route::get('/section-content/{id}', 'SectionContentController@index');
    Route::post('/section-content', 'SectionContentController@store');
    Route::delete('/section-content/{id}', 'SectionContentController@destroy');

    Route::get('/slider', 'SliderController@index')->name('slider.index');
    Route::post('/slider', 'SliderController@store')->name('slider.store');
    Route::post('/slider/{id}', 'SliderController@update')->name('slider.update');
    Route::delete('/slider/{id}', 'SliderController@destroy')->name('slider.destroy');

    Route::get('/subjects', 'SubjectController@index')->name('subjects.index');
    Route::get('/speciality', 'SpecialityController@index')->name('speciality.index');
    Route::get('/minscore', 'TrainingAreaController@index')->name('minscore.index');
    Route::get('/price', 'TrainingAreaController@price')->name('price.index');

    Route::get('/parse', 'ParserController@index')->name('parse.index');
    Route::get('/parse-specialities', 'ParserController@parseFromXls')->name('parse.parseFromXls');
    Route::get('/parse-students', 'ParserJsonController@parseFromJson')->name('parse.parseFromJson');
    Route::get('/parse-areas', 'ParserJsonController@parseAreas')->name('parse.parseAreas');
    Route::get('/parse-sub', 'ParserController@parseFromXlsSub')->name('parse.parseFromXlsSub');

});
Auth::routes();
//Route::get('/parser', 'ParserController@parseFromXls');
Route::get('/contact', 'ContactController@index')->name('contact.index');
Route::get('/select', 'SelectionController@index')->name('selection.index');

Route::get('/stat', 'StatisticController@index')->name('stat.index');
//Route::post('/stat', 'StatisticController@search')->name('stat.searchfio');

//Route::get('/statfaculties', 'StatisticController@fetchFaculties')->name('stat.fetchFaculties');


//Route::get('/', 'StatisticController@index')->name('stat.index');


Route::get('/', 'HomeController@index')->name('home');
Route::get('/{route}', 'PageController@route')->name('pages.route');
