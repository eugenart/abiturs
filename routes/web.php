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
//    Route::redirect('/', '/admin/infoblocks');


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

//    Route::redirect('/', '/admin/subject');

    Route::get('/subjects', 'SubjectController@index')->name('subjects.index');
    Route::get('/speciality', 'SpecialityController@index')->name('speciality.index');
    Route::get('/minscore', 'TrainingAreaController@index')->name('minscore.index');
    Route::get('/price', 'TrainingAreaController@price')->name('price.index');
    Route::get('/parse', 'ParserController@index')->name('parse.index');
    Route::get('/parse-specialities', 'ParserController@parseFromXls')->name('parse.parseFromXls');
    Route::get('/parse-students', 'ParserJsonController@parseFromJson')->name('parse.parseFromJson');
    Route::get('/parse-areas', 'ParserJsonController@parseAreas')->name('parse.parseAreas');


//    Route::get('/course', 'CourseController@index')->name('course.index');
//    Route::post('/course', 'CourseController@store')->name('course.store');
//    Route::post('/course/{id}', 'CourseController@update')->name('course.update');
//    Route::delete('/course/{id}', 'CourseController@destroy')->name('course.destroy');
//
//    Route::get('/subject', 'SubjectController@index')->name('subject.index');
//    Route::post('/subject', 'SubjectController@store')->name('subject.store');
//    Route::post('/subject/{id}', 'SubjectController@update')->name('subject.update');
//    Route::delete('/subject/{id}', 'SubjectController@destroy')->name('subject.destroy');
//
//    Route::get('/subject-list', 'SubjectController@subjectList')->name('subject.list');
//    Route::post('/subject-list', 'SubjectController@addToSubjectList')->name('subject.addToList');
//    Route::delete('/subject-list/{id}', 'SubjectController@deleteFromSubjectList')->name('subject.deleteFromList');


});

//Route::get('/parser', 'ParserController@parseFromXls');

Route::get('/parserjson', 'ParserJsonController@parseFromJson');

Route::get('/stat', function () {
    return view('pages.stat');
});

//
//Route::get('/selection', 'SelectionController@index')->name('selection.index');
//

//
//Route::get('/home', 'HomeController@index')->name('home');
//
//Route::get('/', 'PageController@index')->name('pages.index');
Route::get('/{route}', 'PageController@route')->name('pages.route');
Route::get('/', 'SelectionController@index')->name('selection.index');


