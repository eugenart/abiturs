<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Speciality extends Model
{
    protected $fillable = ['specialityId', 'code', 'name'];

    public function statistics()
    {
        return $this->hasMany(Statistic::class, 'id_speciality');
    }

    public function area()
    {
        return $this->hasOne(TrainingArea::class, 'id_speciality');
    }

    public function specialization()
    {
        return $this->hasMany(Specialization::class, 'id_speciality');
    }

//    public static function allWithSpez()
//    {
//        return DB::table('specialities')
//            ->join('specializations', 'specialities.id', '=', 'specializations.id_speciality')
//            ->select('specialities.*', 'specializations.name as sp_name')
//            ->get();
//    }
}
