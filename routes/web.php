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

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;


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
    Route::post('/infoblock/copy/{copy_id}', 'InfoblockController@copy')->name('infoblock.copy');
    Route::post('/infoblock/archive/{id}', 'ArchiveController@store')->name('infoblock.archive');

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

    Route::post('/download', 'DownloadFileController@index')->name('json.download');

    Route::get('/archive', 'ArchiveController@index_admin')->name('archive.indexadmin');
    Route::get('/get-archives', 'ArchiveController@get_archives')->name('archive.get');


    Route::middleware('role:admin')->group(function () {
        Route::get('/times', 'DateUpdateController@index')->name('times.index');
        Route::post('/times/{id}', 'DateUpdateController@update')->name('times.update');

        Route::get('/cleansing', 'CleansingController@index')->name('cleansing.index');
        Route::post('/cleansing-orders', 'CleansingController@clean_orders')->name('cleansing.orders');
        Route::post('/cleansing-stats', 'CleansingController@clean_stats')->name('cleansing.stats');
        Route::post('/cleansing-statBach', 'CleansingController@clean_table_stat_bach')->name('cleansing.statBach');
        Route::post('/cleansing-statMaster', 'CleansingController@clean_table_stat_master')->name('cleansing.statMaster');
        Route::post('/cleansing-statAsp', 'CleansingController@clean_table_stat_asp')->name('cleansing.statAsp');
        Route::post('/cleansing-statSpo', 'CleansingController@clean_table_stat_spo')->name('cleansing.statSpo');
    });


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

        Route::get('/download-stat-priem', 'TotalStatController@download_all_files')->name('totalstat.download');
        Route::get('/download-orders', 'OrderController@download_all_files')->name('totalstat.download');

});

Route::get('/send_mail', 'SendMailController@index');
Route::get('/send_mail_en', 'SendMailController@english');
Route::get('/send_mail_mrsu', 'SendMailController@mrsu');
Route::get('/contact', 'ContactController@index')->name('contact.index');
//Route::get('/contact/appeal', 'MrsuController@index')->name('mrsu.index');

Route::get('/select/bachelor', 'SelectionController@index')->name('selection.index');
Route::get('/select/foreigner', 'SelectionForeignerController@index')->name('selectionf.index');

Route::get('/statistic/bachelor', 'StatisticController@bachelor')->name('stat.index');
Route::get('/statistic/master', 'StatisticController@master')->name('statmaster.index');
Route::get('/statistic/aspirant', 'StatisticController@asp')->name('statasp.index');
Route::get('/statistic/spo', 'StatisticController@spo')->name('statspo.index');
Route::get('/statistic/total', 'TotalStatController@index')->name('total.index');
Route::get('/orders', 'OrderController@index')->name('order.index');

Route::post('/statistic/getfile', 'StatisticController@createFileXls')->name('statasp.file');

Route::get('/statistic-foreigner/bachelor', 'StatisticController@bachf')->name('statforeigner.index');
Route::get('/statistic-foreigner/asp', 'StatisticController@aspf')->name('stataspforeigner.index');
Route::get('/statistic-foreigner/master', 'StatisticController@masterf')->name('statmasterforeigner.index');

Route::get('/toOvzVer', 'SessionController@toOvzVer')->name('ses.toOvzVer');
Route::get('/backToMainVer', 'SessionController@backToMainVer')->name('ses.backToMainVer');

Route::get('/archive', 'ArchiveController@index')->name('archive.index');
//Route::middleware('role:developer')->group(function () {
    Route::get('/en', 'SessionController@toEn')->name('ses.toEn');
    Route::get('/ru', 'SessionController@toRu')->name('ses.toRu');
//});

//Route::get('/test', 'SessionController@index')->name('test.index');

//Route::post('/test', 'DownloadFileController@index')->name('file.download');
Route::get('/foreign', 'ForeignController@index')->name('foreign.index');

Route::get('/{route}', 'PageController@route')->name('pages.route');
Route::get('/', 'PageController@index')->name('pages.home');



