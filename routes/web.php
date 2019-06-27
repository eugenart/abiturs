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


Route::get('/infoblocks', 'InfoblockController@index')->name('infoblock.index');
Route::post('/infoblock', 'InfoblockController@store')->name('infoblock.store');
Route::post('/infoblock/{id}', 'InfoblockController@update')->name('infoblock.update');
Route::delete('/infoblock/{id}', 'InfoblockController@destroy')->name('infoblock.destroy');

Route::get('/sections', 'SectionController@index')->name('section.index');
Route::post('/section', 'SectionController@store')->name('section.store');
Route::post('/section/{id}', 'SectionController@update')->name('section.update');
Route::delete('/section/{id}', 'SectionController@destroy')->name('section.destroy');

Route::get('/slider', 'SliderController@index')->name('slider.index');
Route::post('/slider', 'SliderController@store')->name('slider.store');
Route::post('/slider/{id}', 'SliderController@update')->name('slider.update');
Route::delete('/slider/{id}', 'SliderController@destroy')->name('slider.destroy');

Route::get('/course', 'CourseController@index')->name('course.index');
Route::post('/course', 'CourseController@store')->name('course.store');
Route::post('/course/{id}', 'CourseController@update')->name('course.update');
Route::delete('/course/{id}', 'CourseController@destroy')->name('course.destroy');

Route::get('/subject', 'SubjectController@index')->name('subject.index');
Route::post('/subject', 'SubjectController@store')->name('subject.store');
Route::post('/subject/{id}', 'SubjectController@update')->name('subject.update');
Route::delete('/subject/{id}', 'SubjectController@destroy')->name('subject.destroy');

Route::get('/subject-list', 'SubjectController@subjectList')->name('subject.list');
Route::post('/subject-list', 'SubjectController@addToSubjectList')->name('subject.addToList');
Route::delete('/subject-list/{id}', 'SubjectController@deleteFromSubjectList')->name('subject.deleteFromList');

Route::get('/ege', function () {
    return view('structure.egeSelect');
});

Route::get('/stat', function () {
    return view('pages.stat');
});

Route::get('/selection', 'SelectionController@index')->name('selection.index');


Route::get('/section-content/{id}', 'SectionContentController@index');
Route::post('/section-content', 'SectionContentController@store');
Route::delete('/section-content/{id}', 'SectionContentController@destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'PageController@index')->name('pages.index');
Route::get('/{route}', 'PageController@route')->name('pages.route');


