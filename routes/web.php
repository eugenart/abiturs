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
//Auth::routes();
Auth::routes(['register' => false]);

Route::middleware('auth')->group(function () {
// Registration Routes...
    Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('/register', 'Auth\RegisterController@register');
});

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
    //специальности специализации
    Route::get('/parse-specialities', 'ParserController@parseFromXls')->name('parse.parseFromXls');
    //дисциплины факультеты
    Route::get('/parse-sub', 'ParserController@parseFromXlsSub')->name('parse.parseFromXlsSub');
    //бюджет не бюджет
    Route::get('/c', 'ParserController@parseFromXlsAdmission')->name('parse.parseFromXlsAdmission');

    //формы обучения, категории, уровни подготовки
    Route::get('/parse-catalogs', 'ParserJsonController@parseCatalogs')->name('parse.parseCatalogs');
    //планы, цены, места
    Route::get('/parse-plans-bach', 'ParserJsonController@parsePlansBach')->name('parse.parsePlansBach');
    Route::get('/parse-plans-master', 'ParserJsonController@parsePlansMaster')->name('parse.parsePlansMaster');
    Route::get('/parse-plans-asp', 'ParserJsonController@parsePlansAspMain')->name('parse.parsePlansAspMain');
    Route::get('/parse-plans-spo', 'ParserJsonController@parsePlansSpo')->name('parse.parsePlansSpo');
    //статистика приема
    Route::get('/parse-students', 'ParserJsonController@parseFromJson')->name('parse.parseFromJson');
    Route::get('/parse-students-master', 'ParserJsonController@parseFromJsonMaster')->name('parse.parseFromJsonMaster');
    Route::get('/parse-students-asp', 'ParserJsonController@parseFromJsonAsp')->name('parse.parseFromJsonAsp');
    Route::get('/parse-students-spo', 'ParserJsonController@parseFromJsonSpo')->name('parse.parseFromJsonSpo');

    Route::get('/parse-contests', 'ParserJsonController@parsePastContests')->name('parse.parsePastContests');




});
//Auth::routes();

Route::get('/send_mail', 'SendMailController@index');

Route::get('/contact', 'ContactController@index')->name('contact.index');
Route::get('/select', 'SelectionController@index')->name('selection.index');
Route::get('/statistic/bachelor', 'StatisticController@index')->name('stat.index');
Route::get('/statistic/master', 'StatisticMasterController@index')->name('statmaster.index');
Route::get('/statistic/aspirant', 'StatisticAspController@index')->name('statasp.index');
Route::get('/statistic/spo', 'StatisticSpoController@index')->name('statspo.index');

Route::get('/toOvzVer', 'SessionController@toOvzVer')->name('ses.toOvzVer');
Route::get('/backToMainVer', 'SessionController@backToMainVer')->name('ses.backToMainVer');
//Route::get('/test', 'SessionController@index')->name('ses.index');

Route::get('/foreign', 'ForeignController@index')->name('foreign.index');

Route::get('/{route}', 'PageController@route')->name('pages.route');
Route::get('/', 'PageController@index')->name('pages.home');



