<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $fillable = ['specializationId', 'name', 'id_speciality'];

    public function speciality() {
        return $this->belongsTo(Speciality::class, 'id_speciality');
    }

    public function statistics() {
        return $this->hasMany(Statistic::class, 'id_specialization');
    }

    public function plan()
    {
        return $this->hasMany(Plan::class, 'id_specialization');
    }
    public function plan_foreigner()
    {
        return $this->hasMany(PlanForeigner::class, 'id_specialization');
    }
}
