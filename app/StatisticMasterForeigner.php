<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatisticMasterForeigner extends Model
{
    protected $fillable = ['id_student', 'id_faculty', 'id_speciality', 'id_specialization',
        'id_preparationLevel', 'id_admissionBasis', 'id_studyForm', 'id_category', 'accept', 'original',
        'summ', 'indAchievement', 'summContest', 'needHostel', 'notice1', 'notice2',
        'id_plan', 'is_chosen', 'id_competition', 'foreigner', 'yellowline', 'acceptCount','stage', 'stage_title'];

    public function student() {
        return $this->belongsTo(StudentMasterForeigner::class, 'id_student');
    }

    public function faculty() {
        return $this->belongsTo(Faculty::class, 'id_faculty');
    }

    public function speciality() {
        return $this->belongsTo(Speciality::class, 'id_speciality');
    }

    public function specialization() {
        return $this->belongsTo(Specialization::class, 'id_specialization');
    }
    public function score() {
        return $this->hasMany(ScoreMasterForeigner::class, 'id_statistic');
    }

    public function preparationLevel() {
        return $this->belongsTo(PreparationLevel::class, 'id_preparationLevel');
    }

    public function admissionBasis() {
        return $this->belongsTo(AdmissionBasis::class, 'id_admissionBasis');
    }
    public function studyForm() {
        return $this->belongsTo(StudyForm::class, 'id_studyForm');
    }
    public function category() {
        return $this->belongsTo(Category::class, 'id_category');
    }
}
