<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanSpo extends Model
{
    protected $fillable = ['planId', 'id_faculty', 'id_studyForm', 'id_speciality', 'id_specialization', 'years'];

    public function plan_comps() {
        return $this->hasMany(PlanCompetitionSpo::class, 'id_plan');
    }

    public function faculty() {
        return $this->belongsTo(Faculty::class, 'id_faculty');
    }
    public function studyForm() {
        return $this->belongsTo(StudyForm::class, 'id_studyForm');
    }
    public function speciality() {
        return $this->belongsTo(Speciality::class, 'id_speciality');
    }
    public function specialization() {
        return $this->belongsTo(Specialization::class, 'id_specialization');
    }
}
