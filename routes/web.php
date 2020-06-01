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

use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

Route::middleware('auth')->group(function () {
// Registration Routes...
    Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('/register', 'Auth\RegisterController@register');
});

Route::get('/email', function () {
    Mail::to('artashkinep@mrsu.ru')->send(new WelcomeEmail());
    return new WelcomeEmail();
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

//    Route::get('/test', 'XlsMakerController@index')->name('xls.create');
    Route::post('/download', 'DownloadFileController@index')->name('json.download');
//    Route::get('/download', 'DownloadFileController@stop')->name('json.download');


    Route::get('/parse', 'ParserController@index')->name('parse.index');
    //специальности специализации
    Route::get('/parse-specialities', 'ParserController@parseSpecialitiesLocal')->name('parse.parseSpec');
    //дисциплины
    Route::get('/parse-subjects', 'ParserController@parseSubjectsLocal')->name('parse.parseSub');
    // факультеты
    Route::get('/parse-faculties', 'ParserController@parseFacultiesLocal')->name('parse.parseFac');
    //бюджет не бюджет
    Route::get('/parse-admission', 'ParserController@parseAdmissionBasesLocal')->name('parse.parseAdm');

    //формы обучения, категории, уровни подготовки
    Route::get('/parse-catalogs', 'ParserJsonController@parseCatalogsLocal')->name('parse.parseCatalogs');
    //планы, цены, места
    Route::get('/parse-plans-bach', 'ParserJsonController@parsePlansBachLocal')->name('parse.parsePlansBach');
    Route::get('/parse-plans-master', 'ParserJsonController@parsePlansMasterLocal')->name('parse.parsePlansMaster');
    Route::get('/parse-plans-asp', 'ParserJsonController@parsePlansAspMainLocal')->name('parse.parsePlansAspMain');
    Route::get('/parse-plans-spo', 'ParserJsonController@parsePlansSpoLocal')->name('parse.parsePlansSpo');
    //статистика приема
    Route::get('/parse-students', 'ParserJsonController@parseStatBachAllLocal')->name('parse.parseFromJson');
    Route::get('/parse-students-master', 'ParserJsonController@parseStatMasterAllLocal')->name('parse.parseFromJsonMaster');
    Route::get('/parse-students-asp', 'ParserJsonController@parseStatAspAllLocal')->name('parse.parseFromJsonAsp');
    Route::get('/parse-students-spo', 'ParserJsonController@parseStatSpoAllLocal')->name('parse.parseFromJsonSpo');

    Route::get('/parse-contests', 'ParserJsonController@parsePastContestsLocal')->name('parse.parsePastContests');




});
//Auth::routes();

Route::get('/send_mail', 'SendMailController@index');

Route::get('/contact', 'ContactController@index')->name('contact.index');
Route::get('/select', 'SelectionController@index')->name('selection.index');
Route::get('/statistic/bachelor', 'StatisticController@index')->name('stat.index');
Route::get('/statistic/master', 'StatisticMasterController@index')->name('statmaster.index');
Route::get('/statistic/aspirant', 'StatisticAspController@index')->name('statasp.index');
Route::get('/statistic/spo', 'StatisticSpoController@index')->name('statspo.index');
Route::get('/statistic/total', 'TotalStatController@index')->name('total.index');

Route::get('/toOvzVer', 'SessionController@toOvzVer')->name('ses.toOvzVer');
Route::get('/backToMainVer', 'SessionController@backToMainVer')->name('ses.backToMainVer');

//Route::get('/test', 'DownloadFileController@index')->name('file.index');

//Route::post('/test', 'DownloadFileController@index')->name('file.download');
Route::get('/foreign', 'ForeignController@index')->name('foreign.index');

Route::get('/{route}', 'PageController@route')->name('pages.route');
Route::get('/', 'PageController@index')->name('pages.home');



