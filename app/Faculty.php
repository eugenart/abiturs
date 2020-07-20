<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Faculty extends Model
{
    protected $fillable = ['facultyId', 'name', 'en_name'];

    public function statistics() {
        return $this->hasMany(Statistic::class, 'id_faculty');
    }

    //больше не нужно
//    public function areas() {
//        return $this->hasMany(FacultyArea::class, 'id_faculty');
//    }

    public function plans() {
        return $this->hasMany(Plan::class, 'id_faculty');
    }
    public function plansAsp() {
        return $this->hasMany(PlanAsp::class, 'id_faculty');
    }
    public function plansMaster() {
        return $this->hasMany(PlanMaster::class, 'id_faculty');
    }
    public function plansSpo() {
        return $this->hasMany(PlanSpo::class, 'id_faculty');
    }
    public function plans_foreigner() {
        return $this->hasMany(PlanForeigner::class, 'id_faculty');
    }


    public static function facultyJoinStat() {
       $query =  DB::table('faculties')
            ->select('faculties.name')
            ->distinct()
            ->get();
    }
}
