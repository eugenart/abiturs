<?php

namespace App\Http\Controllers;

use App\Traits\ParserJsonTrait;
use Illuminate\Http\Request;
use Mockery\Exception;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use Throwable;

class ParserJsonController extends Controller
{
    use ParserJsonTrait;

//------------------------НАЧАЛО парсинг статистики Бакалавры--------------------------------
    public function parseCatalogsLocal()
    {
        return $this->parseCatalogs();
    }

    public function parseStatBachAllLocal(Request $request)
    {
        return $this->parseStatBachAll();
    }
//------------------------КОНЕЦ парсинг статистики Бакалавры--------------------------------

//------------------------НАЧАЛО парсинг статистики Магистры--------------------------------
    public function parseStatMasterAllLocal(Request $request)
    {
        return $this->parseStatMasterAll();
    }
//------------------------КОНЕЦ парсинг статистики Магистры--------------------------------

//------------------------НАЧАЛО парсинг статистики Аспиранты--------------------------------
    public function parseStatAspAllLocal(Request $request)
    {
        return $this->parseStatAspAll();
    }
//------------------------КОНЕЦ парсинг статистики Аспиранты--------------------------------

//------------------------НАЧАЛО парсинг статистики СПО--------------------------------
    public function parseStatSpoAllLocal(Request $request)
    {
        return $this->parseStatSpoAll();
    }
//------------------------КОНЕЦ парсинг статистики СПО--------------------------------


//------------------------НАЧАЛО парсинг планов Бакалавров--------------------------------
    //парсинг планов, цен, мест, баллов БакалавриатСпец
    public function parsePlansBachLocal(Request $request)
    {
        return $this->parsePlansBach();
    }
//------------------------КОНЕЦ парсинг планов Бакалавров--------------------------------

//------------------------НАЧАЛО парсинг планов Магистров--------------------------------
    //парсинг планов, цен, мест, баллов Магистры
    public function parsePlansMasterLocal(Request $request)
    {
        return $this->parsePlansMaster();
    }
//------------------------КОНЕЦ парсинг планов Магистров--------------------------------

//------------------------НАЧАЛО парсинг планов Аспиранты--------------------------------
    //парсинг планов, цен, мест, баллов Аспиранты
    public function parsePlansAspMainLocal(Request $request)
    {
        return $this->parsePlansAspMain();
    }
//------------------------КОНЕЦ парсинг планов Аспиранты--------------------------------

//------------------------НАЧАЛО парсинг планов СПО--------------------------------

    public function parsePlansSpoLocal(Request $request)
    {
        return $this->parsePlansSpo();
    }
//------------------------КОНЕЦ парсинг планов СПО--------------------------------


    //парсинг баллов за прошлые года
    public function parsePastContestsLocal()
    {
        return $this->parsePastContests();
    }


}
