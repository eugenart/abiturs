<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Speciality extends Model
{
    protected $fillable = ['specialityId', 'code', 'name', 'en_name'];

    public function statistics()
    {
        return $this->hasMany(Statistic::class, 'id_speciality');
    }
    //больше не нужно
    public function area()
    {
        return $this->hasOne(TrainingArea::class, 'id_speciality');
    }
    public function plan()
    {
        return $this->hasMany(Plan::class, 'id_speciality');
    }
    public function plan_foreigner()
    {
        return $this->hasMany(PlanForeigner::class, 'id_speciality');
    }
    public function specialization()
    {
        return $this->hasMany(Specialization::class, 'id_speciality');
    }

    public function pastContests()
    {
        return $this->hasMany(PastContests::class, 'id_studyForm');
    }

//    public static function allWithSpez()
//    {
//        return DB::table('specialities')
//            ->join('specializations', 'specialities.id', '=', 'specializations.id_speciality')
//            ->select('specialities.*', 'specializations.name as sp_name')
//            ->get();
//    }

    public static function specJoinStat()
    {
        $query = DB::table('specialities')
            ->join('statistics', 'specialities.id', '=', 'statistics.id_speciality')
            ->select('specialities.*')
            ->get();

    }
}
