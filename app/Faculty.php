<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Faculty extends Model
{
    protected $fillable = ['facultyId', 'name'];

    public function statistics() {
        return $this->hasMany(Statistic::class, 'id_faculty');
    }

    //больше не нужно
    public function areas() {
        return $this->hasMany(FacultyArea::class, 'id_faculty');
    }

    public function plans() {
        return $this->hasMany(Plan::class, 'id_faculty');
    }

    public static function facultyJoinStat() {
       $query =  DB::table('faculties')
            //->join('statistics', 'statistics.id_faculty', '=', 'faculties.id')
            ->select('faculties.name')
            ->distinct()
            ->get();
    }
}
