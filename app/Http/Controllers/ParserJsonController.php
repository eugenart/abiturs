<?php

namespace App\Http\Controllers;

use App\AdmissionBasis;
use App\Category;
use App\Competition;
use App\CompetitionAsp;
use App\CompetitionMaster;
use App\CompetitionSpo;
use App\Faculty;
use App\Freeseats_bases;
use App\Freeseats_basesAsp;
use App\Freeseats_basesMaster;
use App\Freeseats_basesSpo;
use App\PastContests;
use App\Plan;
use App\PlanAsp;
use App\PlanCompetition;
use App\PlanCompetitionAsp;
use App\PlanCompetitionMaster;
use App\PlanCompetitionSpo;
use App\PlanCompScore;
use App\PlanCompScoreAsp;
use App\PlanCompScoreMaster;
use App\PlanCompScoreSpo;
use App\PlanMaster;
use App\PlanSpo;
use App\PreparationLevel;
use App\Price;
use App\PriceAsp;
use App\PriceMaster;
use App\PriceSpo;
use App\Score;
use App\ScoreAsp;
use App\ScoreMaster;
use App\ScoreSpo;
use App\Speciality;
use App\Specialization;
use App\Statistic;
use App\StatisticAsp;
use App\StatisticMaster;
use App\StatisticSpo;
use App\Student;
use App\StudentAsp;
use App\StudentMaster;
use App\StudentSpo;
use App\StudyForm;
use App\Subject;
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
    public function parsePlansBachSpecSar()
    {
        set_time_limit(0);
        $filejson = file_get_contents(storage_path('app/public/files/plans/plans_saransk/plans_sar_bach.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        Plan::truncate();
        Competition::truncate();
        PlanCompetition::truncate();
        PlanCompScore::truncate();
        Price::truncate();
        Freeseats_bases::truncate();

        $arr_plan = array();
        $arr_competition = array();
        $arr_plan_comp = array();
        $arr_plan_comp_score = array();
        $arr_prices = array();
        $arr_freeseats = array();
        $count_plan = 0;


        foreach ($json_data as $k => $element) {
            if (!$element['Competition']['foreigner']) {
                $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();

                //заполним массив планов
                $plan = array(
                    'planId' => $element['Plan']['planId'],
                    'id_faculty' => intval($id_faculty->id),
                    'id_studyForm' => intval($id_studyForm->id),
                    'id_speciality' => intval($id_speciality->id),
                    'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                    'years' => intval($element['Plan']['years'])

                );
                //заполним массив испытаний
                $competition = array(
                    'competitionId' => $element['Competition']['CompetitionId'],
                    'competitionName' => $element['Competition']['CompetitionName']
                );


                $arr_plan[] = $plan;
                $arr_competition[] = $competition;
                $count_plan++; //если не делать юник для планов которые повторяются то id плана и компетишина равны
                //массив связей плана и испытания
                $plan_comp = array(
                    'id_plan' => $count_plan,
                    'id_competition' => $count_plan,
                    'freeSeatsNumber' => $element['freeSeatsNumber']
                );

                $arr_plan_comp[] = $plan_comp;

                //связь предметов-оценок с объедением плана-исптания
                foreach ($element['subjects'] as $subjectItem) {
                    $id_subject = Subject::where('subjectId', '=', $subjectItem['subjectId'])->first();

                    $subject = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_subject' => intval($id_subject->id),
                        'minScore' => $subjectItem['minScore']
                    );
                    $arr_plan_comp_score[] = $subject;
                }

                foreach ($element['Prices'] as $priceItem) {
                    $price = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'price' => $priceItem['Price'],
                        'info' => $priceItem['info']
                    );
                    $arr_prices[] = $price;
                }

                foreach ($element['admissionBasis'] as $basisItem) {
                    $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();

                    $freeseat = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_admissionBasis' => intval($id_admissionBasis->id),
                        'value' => $basisItem['value']
                    );
                    $arr_freeseats[] = $freeseat;
                }
            }
        }

        Plan::insert($arr_plan);
        Competition::insert($arr_competition);
        PlanCompetition::insert($arr_plan_comp);
        PlanCompScore::insert($arr_plan_comp_score);
        Price::insert($arr_prices);
        Freeseats_bases::insert($arr_freeseats);


    }

    //парсинг планов, цен, мест, баллов БакалавриатСпец Рузаевка
    public function parsePlansBachSpecRuz()
    {
        set_time_limit(0);
        $filejson = file_get_contents(storage_path('app/public/files/plans/plans_rim/plans_rim_bach.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        $arr_plan = array();
        $arr_competition = array();
        $arr_plan_comp = array();
        $arr_plan_comp_score = array();
        $arr_prices = array();
        $arr_freeseats = array();

        $count_plan_db = Plan::count();
        $count_plan = intval($count_plan_db);

        foreach ($json_data as $k => $element) {
            if (!$element['Competition']['foreigner']) {
                $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();

                //заполним массив планов
                $plan = array(
                    'planId' => $element['Plan']['planId'],
                    'id_faculty' => intval($id_faculty->id),
                    'id_studyForm' => intval($id_studyForm->id),
                    'id_speciality' => intval($id_speciality->id),
                    'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                    'years' => intval($element['Plan']['years'])

                );
                //заполним массив испытаний
                $competition = array(
                    'competitionId' => $element['Competition']['CompetitionId'],
                    'competitionName' => $element['Competition']['CompetitionName']
                );


                $arr_plan[] = $plan;
                $arr_competition[] = $competition;
                $count_plan++; //если не делать юник для планов которые повторяются то id плана и компетишина равны
                //массив связей плана и испытания
                $plan_comp = array(
                    'id_plan' => $count_plan,
                    'id_competition' => $count_plan,
                    'freeSeatsNumber' => $element['freeSeatsNumber']
                );

                $arr_plan_comp[] = $plan_comp;

                //связь предметов-оценок с объедением плана-исптания
                foreach ($element['subjects'] as $subjectItem) {
                    $id_subject = Subject::where('subjectId', '=', $subjectItem['subjectId'])->first();

                    $subject = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_subject' => intval($id_subject->id),
                        'minScore' => $subjectItem['minScore']
                    );
                    $arr_plan_comp_score[] = $subject;
                }

                foreach ($element['Prices'] as $priceItem) {
                    $price = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'price' => $priceItem['Price'],
                        'info' => $priceItem['info']
                    );
                    $arr_prices[] = $price;
                }

                foreach ($element['admissionBasis'] as $basisItem) {
                    $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();

                    $freeseat = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_admissionBasis' => intval($id_admissionBasis->id),
                        'value' => $basisItem['value']
                    );
                    $arr_freeseats[] = $freeseat;
                }
            }
        }

        Plan::insert($arr_plan);
        Competition::insert($arr_competition);
        PlanCompetition::insert($arr_plan_comp);
        PlanCompScore::insert($arr_plan_comp_score);
        Price::insert($arr_prices);
        Freeseats_bases::insert($arr_freeseats);

    }

    public function parsePlansBach(Request $request)
    {
        set_time_limit(1200);

        $this->parsePlansBachSpecSar();
        $this->parsePlansBachSpecRuz(); //отдельно запускать нельзя, только в такой последовательности

        return json_encode('Планы, цены за обучение и количество мест бакалавриата и специалитета успешно выгружены!');
    }
//------------------------КОНЕЦ парсинг планов Бакалавров--------------------------------

//------------------------НАЧАЛО парсинг планов Магистров--------------------------------
    //парсинг планов, цен, мест, баллов Магистры
    public function parsePlansMasterSar()
    {
        set_time_limit(0);
        $filejson = file_get_contents(storage_path('app/public/files/plans/plans_saransk/plans_sar_master.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        PlanMaster::truncate();
        CompetitionMaster::truncate();
        PlanCompetitionMaster::truncate();
        PlanCompScoreMaster::truncate();
        PriceMaster::truncate();
        Freeseats_basesMaster::truncate();

        $arr_plan = array();
        $arr_competition = array();
        $arr_plan_comp = array();
        $arr_plan_comp_score = array();
        $arr_prices = array();
        $arr_freeseats = array();
        $count_plan = 0;


        foreach ($json_data as $k => $element) {
            if (!$element['Competition']['foreigner']) {
                $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();

                //заполним массив планов
                $plan = array(
                    'planId' => $element['Plan']['planId'],
                    'id_faculty' => intval($id_faculty->id),
                    'id_studyForm' => intval($id_studyForm->id),
                    'id_speciality' => intval($id_speciality->id),
                    'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                    'years' => intval($element['Plan']['years'])

                );
                //заполним массив испытаний
                $competition = array(
                    'competitionId' => $element['Competition']['CompetitionId'],
                    'competitionName' => $element['Competition']['CompetitionName']
                );


                $arr_plan[] = $plan;
                $arr_competition[] = $competition;
                $count_plan++; //если не делать юник для планов которые повторяются то id плана и компетишина равны
                //массив связей плана и испытания
                $plan_comp = array(
                    'id_plan' => $count_plan,
                    'id_competition' => $count_plan,
                    'freeSeatsNumber' => $element['freeSeatsNumber']
                );

                $arr_plan_comp[] = $plan_comp;

                //связь предметов-оценок с объедением плана-исптания
                foreach ($element['subjects'] as $subjectItem) {
                    $id_subject = Subject::where('subjectId', '=', $subjectItem['subjectId'])->first();

                    $subject = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_subject' => intval($id_subject->id),
                        'minScore' => $subjectItem['minScore']
                    );
                    $arr_plan_comp_score[] = $subject;
                }

                foreach ($element['Prices'] as $priceItem) {
                    $price = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'price' => $priceItem['Price'],
                        'info' => $priceItem['info']
                    );
                    $arr_prices[] = $price;
                }

                foreach ($element['admissionBasis'] as $basisItem) {
                    $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();

                    $freeseat = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_admissionBasis' => intval($id_admissionBasis->id),
                        'value' => $basisItem['value']
                    );
                    $arr_freeseats[] = $freeseat;
                }
            }
        }

        PlanMaster::insert($arr_plan);
        CompetitionMaster::insert($arr_competition);
        PlanCompetitionMaster::insert($arr_plan_comp);
        PlanCompScoreMaster::insert($arr_plan_comp_score);
        PriceMaster::insert($arr_prices);
        Freeseats_basesMaster::insert($arr_freeseats);

    }

    //парсинг планов, цен, мест, баллов БакалавриатСпец Рузаевка
    public function parsePlansMasterRuz()
    {
        set_time_limit(0);
        $filejson = file_get_contents(storage_path('app/public/files/plans/plans_rim/plans_rim_master.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        $arr_plan = array();
        $arr_competition = array();
        $arr_plan_comp = array();
        $arr_plan_comp_score = array();
        $arr_prices = array();
        $arr_freeseats = array();

        $count_plan_db = PlanMaster::count();
        $count_plan = intval($count_plan_db);

        foreach ($json_data as $k => $element) {
            if (!$element['Competition']['foreigner']) {
                $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();

                //заполним массив планов
                $plan = array(
                    'planId' => $element['Plan']['planId'],
                    'id_faculty' => intval($id_faculty->id),
                    'id_studyForm' => intval($id_studyForm->id),
                    'id_speciality' => intval($id_speciality->id),
                    'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                    'years' => intval($element['Plan']['years'])

                );
                //заполним массив испытаний
                $competition = array(
                    'competitionId' => $element['Competition']['CompetitionId'],
                    'competitionName' => $element['Competition']['CompetitionName']
                );


                $arr_plan[] = $plan;
                $arr_competition[] = $competition;
                $count_plan++; //если не делать юник для планов которые повторяются то id плана и компетишина равны
                //массив связей плана и испытания
                $plan_comp = array(
                    'id_plan' => $count_plan,
                    'id_competition' => $count_plan,
                    'freeSeatsNumber' => $element['freeSeatsNumber']
                );

                $arr_plan_comp[] = $plan_comp;

                //связь предметов-оценок с объедением плана-исптания
                foreach ($element['subjects'] as $subjectItem) {
                    $id_subject = Subject::where('subjectId', '=', $subjectItem['subjectId'])->first();

                    $subject = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_subject' => intval($id_subject->id),
                        'minScore' => $subjectItem['minScore']
                    );
                    $arr_plan_comp_score[] = $subject;
                }

                foreach ($element['Prices'] as $priceItem) {
                    $price = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'price' => $priceItem['Price'],
                        'info' => $priceItem['info']
                    );
                    $arr_prices[] = $price;
                }

                foreach ($element['admissionBasis'] as $basisItem) {
                    $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();

                    $freeseat = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_admissionBasis' => intval($id_admissionBasis->id),
                        'value' => $basisItem['value']
                    );
                    $arr_freeseats[] = $freeseat;
                }
            }
        }

        PlanMaster::insert($arr_plan);
        CompetitionMaster::insert($arr_competition);
        PlanCompetitionMaster::insert($arr_plan_comp);
        PlanCompScoreMaster::insert($arr_plan_comp_score);
        PriceMaster::insert($arr_prices);
        Freeseats_basesMaster::insert($arr_freeseats);

    }

    public function parsePlansMaster(Request $request)
    {
        set_time_limit(1200);

        $this->parsePlansMasterSar();
        $this->parsePlansMasterRuz(); //отдельно запускать нельзя, только в такой последовательности

        return json_encode('Планы, цены за обучение и количество мест магистратуры успешно выгружены!');
    }
//------------------------КОНЕЦ парсинг планов Магистров--------------------------------



//------------------------НАЧАЛО парсинг планов Аспиранты--------------------------------
    //парсинг планов, цен, мест, баллов Аспиранты
    public function parsePlansAsp()
    {
        set_time_limit(0);
        $filejson = file_get_contents(storage_path('app/public/files/plans/plans_saransk/plans_sar_asp.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        PlanAsp::truncate();
        CompetitionAsp::truncate();
        PlanCompetitionAsp::truncate();
        PlanCompScoreAsp::truncate();
        PriceAsp::truncate();
        Freeseats_basesAsp::truncate();

        $arr_plan = array();
        $arr_competition = array();
        $arr_plan_comp = array();
        $arr_plan_comp_score = array();
        $arr_prices = array();
        $arr_freeseats = array();
        $count_plan = 0;


        foreach ($json_data as $k => $element) {
            if (!$element['Competition']['foreigner']) {
                $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();

                //заполним массив планов
                $plan = array(
                    'planId' => $element['Plan']['planId'],
                    'id_faculty' => intval($id_faculty->id),
                    'id_studyForm' => intval($id_studyForm->id),
                    'id_speciality' => intval($id_speciality->id),
                    'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                    'years' => intval($element['Plan']['years'])

                );
                //заполним массив испытаний
                $competition = array(
                    'competitionId' => $element['Competition']['CompetitionId'],
                    'competitionName' => $element['Competition']['CompetitionName']
                );


                $arr_plan[] = $plan;
                $arr_competition[] = $competition;
                $count_plan++; //если не делать юник для планов которые повторяются то id плана и компетишина равны
                //массив связей плана и испытания
                $plan_comp = array(
                    'id_plan' => $count_plan,
                    'id_competition' => $count_plan,
                    'freeSeatsNumber' => $element['freeSeatsNumber']
                );

                $arr_plan_comp[] = $plan_comp;

                //связь предметов-оценок с объедением плана-исптания
                foreach ($element['subjects'] as $subjectItem) {
                    $id_subject = Subject::where('subjectId', '=', $subjectItem['subjectId'])->first();

                    $subject = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_subject' => intval($id_subject->id),
                        'minScore' => $subjectItem['minScore']
                    );
                    $arr_plan_comp_score[] = $subject;
                }

                foreach ($element['Prices'] as $priceItem) {
                    $price = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'price' => $priceItem['Price'],
                        'info' => $priceItem['info']
                    );
                    $arr_prices[] = $price;
                }

                foreach ($element['admissionBasis'] as $basisItem) {
                    $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();

                    $freeseat = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_admissionBasis' => intval($id_admissionBasis->id),
                        'value' => $basisItem['value']
                    );
                    $arr_freeseats[] = $freeseat;
                }
            }
        }

        PlanAsp::insert($arr_plan);
        CompetitionAsp::insert($arr_competition);
        PlanCompetitionAsp::insert($arr_plan_comp);
        PlanCompScoreAsp::insert($arr_plan_comp_score);
        PriceAsp::insert($arr_prices);
        Freeseats_basesAsp::insert($arr_freeseats);

    }

    public function parsePlansAspMain(Request $request)
    {
        set_time_limit(1200);

        $this->parsePlansAsp();

        return json_encode('Планы, цены за обучение и количество мест аспирантуры успешно выгружены!');
    }
//------------------------КОНЕЦ парсинг планов Аспиранты--------------------------------

//------------------------НАЧАЛО парсинг планов СПО--------------------------------
    //парсинг планов, цен, мест, баллов СПО
    public function parsePlansSpoSar()
    {
        set_time_limit(0);
        $filejson = file_get_contents(storage_path('app/public/files/plans/plans_saransk/plans_sar_spo.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        PlanSpo::truncate();
        CompetitionSpo::truncate();
        PlanCompetitionSpo::truncate();
        PlanCompScoreSpo::truncate();
        PriceSpo::truncate();
        Freeseats_basesSpo::truncate();

        $arr_plan = array();
        $arr_competition = array();
        $arr_plan_comp = array();
        $arr_plan_comp_score = array();
        $arr_prices = array();
        $arr_freeseats = array();
        $count_plan = 0;


        foreach ($json_data as $k => $element) {
            if (!$element['Competition']['foreigner']) {
                $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();

                //заполним массив планов
                $plan = array(
                    'planId' => $element['Plan']['planId'],
                    'id_faculty' => intval($id_faculty->id),
                    'id_studyForm' => intval($id_studyForm->id),
                    'id_speciality' => intval($id_speciality->id),
                    'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                    'years' => intval($element['Plan']['years'])

                );
                //заполним массив испытаний
                $competition = array(
                    'competitionId' => $element['Competition']['CompetitionId'],
                    'competitionName' => $element['Competition']['CompetitionName']
                );


                $arr_plan[] = $plan;
                $arr_competition[] = $competition;
                $count_plan++; //если не делать юник для планов которые повторяются то id плана и компетишина равны
                //массив связей плана и испытания
                $plan_comp = array(
                    'id_plan' => $count_plan,
                    'id_competition' => $count_plan,
                    'freeSeatsNumber' => $element['freeSeatsNumber']
                );

                $arr_plan_comp[] = $plan_comp;

                //связь предметов-оценок с объедением плана-исптания
                foreach ($element['subjects'] as $subjectItem) {
                    $id_subject = Subject::where('subjectId', '=', $subjectItem['subjectId'])->first();

                    $subject = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_subject' => intval($id_subject->id),
                        'minScore' => $subjectItem['minScore']
                    );
                    $arr_plan_comp_score[] = $subject;
                }

                foreach ($element['Prices'] as $priceItem) {
                    $price = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'price' => $priceItem['Price'],
                        'info' => $priceItem['info']
                    );
                    $arr_prices[] = $price;
                }

                foreach ($element['admissionBasis'] as $basisItem) {
                    $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();

                    $freeseat = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_admissionBasis' => intval($id_admissionBasis->id),
                        'value' => $basisItem['value']
                    );
                    $arr_freeseats[] = $freeseat;
                }
            }
        }

        PlanSpo::insert($arr_plan);
        CompetitionSpo::insert($arr_competition);
        PlanCompetitionSpo::insert($arr_plan_comp);
        PlanCompScoreSpo::insert($arr_plan_comp_score);
        PriceSpo::insert($arr_prices);
        Freeseats_basesSpo::insert($arr_freeseats);

    }

    //парсинг планов, цен, мест, баллов СПО Рузаевка
    public function parsePlansSpoRuz()
    {
        set_time_limit(0);
        $filejson = file_get_contents(storage_path('app/public/files/plans/plans_rim/plans_rim_spo.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        $arr_plan = array();
        $arr_competition = array();
        $arr_plan_comp = array();
        $arr_plan_comp_score = array();
        $arr_prices = array();
        $arr_freeseats = array();

        $count_plan_db = PlanSpo::count();
        $count_plan = intval($count_plan_db);

        foreach ($json_data as $k => $element) {
            if (!$element['Competition']['foreigner']) {
                $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();

                //заполним массив планов
                $plan = array(
                    'planId' => $element['Plan']['planId'],
                    'id_faculty' => intval($id_faculty->id),
                    'id_studyForm' => intval($id_studyForm->id),
                    'id_speciality' => intval($id_speciality->id),
                    'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                    'years' => intval($element['Plan']['years'])

                );
                //заполним массив испытаний
                $competition = array(
                    'competitionId' => $element['Competition']['CompetitionId'],
                    'competitionName' => $element['Competition']['CompetitionName']
                );


                $arr_plan[] = $plan;
                $arr_competition[] = $competition;
                $count_plan++; //если не делать юник для планов которые повторяются то id плана и компетишина равны
                //массив связей плана и испытания
                $plan_comp = array(
                    'id_plan' => $count_plan,
                    'id_competition' => $count_plan,
                    'freeSeatsNumber' => $element['freeSeatsNumber']
                );

                $arr_plan_comp[] = $plan_comp;

                //связь предметов-оценок с объедением плана-исптания
                foreach ($element['subjects'] as $subjectItem) {
                    $id_subject = Subject::where('subjectId', '=', $subjectItem['subjectId'])->first();

                    $subject = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_subject' => intval($id_subject->id),
                        'minScore' => $subjectItem['minScore']
                    );
                    $arr_plan_comp_score[] = $subject;
                }

                foreach ($element['Prices'] as $priceItem) {
                    $price = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'price' => $priceItem['Price'],
                        'info' => $priceItem['info']
                    );
                    $arr_prices[] = $price;
                }

                foreach ($element['admissionBasis'] as $basisItem) {
                    $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();

                    $freeseat = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_admissionBasis' => intval($id_admissionBasis->id),
                        'value' => $basisItem['value']
                    );
                    $arr_freeseats[] = $freeseat;
                }
            }
        }

        PlanSpo::insert($arr_plan);
        CompetitionSpo::insert($arr_competition);
        PlanCompetitionSpo::insert($arr_plan_comp);
        PlanCompScoreSpo::insert($arr_plan_comp_score);
        PriceSpo::insert($arr_prices);
        Freeseats_basesSpo::insert($arr_freeseats);

    }

    //парсинг планов, цен, мест, баллов СПО Ковылкино
    public function parsePlansSpoKov()
    {
        set_time_limit(0);
        $filejson = file_get_contents(storage_path('app/public/files/plans/plans_kov/plans_kov_spo.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        $arr_plan = array();
        $arr_competition = array();
        $arr_plan_comp = array();
        $arr_plan_comp_score = array();
        $arr_prices = array();
        $arr_freeseats = array();

        $count_plan_db = PlanSpo::count();
        $count_plan = intval($count_plan_db);

        foreach ($json_data as $k => $element) {
            if (!$element['Competition']['foreigner']) {
                $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();

                //заполним массив планов
                $plan = array(
                    'planId' => $element['Plan']['planId'],
                    'id_faculty' => intval($id_faculty->id),
                    'id_studyForm' => intval($id_studyForm->id),
                    'id_speciality' => intval($id_speciality->id),
                    'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                    'years' => intval($element['Plan']['years'])

                );
                //заполним массив испытаний
                $competition = array(
                    'competitionId' => $element['Competition']['CompetitionId'],
                    'competitionName' => $element['Competition']['CompetitionName']
                );


                $arr_plan[] = $plan;
                $arr_competition[] = $competition;
                $count_plan++; //если не делать юник для планов которые повторяются то id плана и компетишина равны
                //массив связей плана и испытания
                $plan_comp = array(
                    'id_plan' => $count_plan,
                    'id_competition' => $count_plan,
                    'freeSeatsNumber' => $element['freeSeatsNumber']
                );

                $arr_plan_comp[] = $plan_comp;

                //связь предметов-оценок с объедением плана-исптания
                foreach ($element['subjects'] as $subjectItem) {
                    $id_subject = Subject::where('subjectId', '=', $subjectItem['subjectId'])->first();

                    $subject = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_subject' => intval($id_subject->id),
                        'minScore' => $subjectItem['minScore']
                    );
                    $arr_plan_comp_score[] = $subject;
                }

                foreach ($element['Prices'] as $priceItem) {
                    $price = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'price' => $priceItem['Price'],
                        'info' => $priceItem['info']
                    );
                    $arr_prices[] = $price;
                }

                foreach ($element['admissionBasis'] as $basisItem) {
                    $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();

                    $freeseat = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_admissionBasis' => intval($id_admissionBasis->id),
                        'value' => $basisItem['value']
                    );
                    $arr_freeseats[] = $freeseat;
                }
            }
        }

        PlanSpo::insert($arr_plan);
        CompetitionSpo::insert($arr_competition);
        PlanCompetitionSpo::insert($arr_plan_comp);
        PlanCompScoreSpo::insert($arr_plan_comp_score);
        PriceSpo::insert($arr_prices);
        Freeseats_basesSpo::insert($arr_freeseats);

    }

    public function parsePlansSpo(Request $request)
    {
        set_time_limit(1200);

        $this->parsePlansSpoSar();
        $this->parsePlansSpoRuz(); //отдельно запускать нельзя, только в такой последовательности
        $this->parsePlansSpoKov(); //отдельно запускать нельзя, только в такой последовательности

        return json_encode('Планы, цены за обучение и количество мест СПО успешно выгружены!');
    }
//------------------------КОНЕЦ парсинг планов СПО--------------------------------


    //парсинг баллов за прошлые года
    public function parsePastContests()
    {
        ini_set('memory_limit', '1024M');
        $filejson = file_get_contents(storage_path('app/public/files/pastContests/past_contests.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        PastContests::truncate();

        $arr_contests = array();

        foreach ($json_data as $k => $element) {
            $id_studyForm = StudyForm::where('name', '=', $element['trainingForm'])->first();
            $id_admissionBasis = AdmissionBasis::where('baseId', '=', $element['IdBasis'])->first();
            $id_speciality = Speciality::where('specialityId', '=', $element['trainingAreasId'])->first();


            $contest = array(
                'id_studyForm' => intval($id_studyForm->id),
                'id_admissionBasis' => intval($id_admissionBasis->id),
                'id_speciality' => intval($id_speciality->id),
                'year' => $element['year'],
                'minScore' => $element['value']
            );

            $arr_contests[] = $contest;
        }

        PastContests::insert($arr_contests);

        return json_encode('Статистика предыдущих лет успешно выгружена!');

    }


}
