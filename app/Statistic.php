<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $fillable = ['id_student', 'id_faculty', 'id_speciality', 'id_specialization',
        'preparationLevel', 'admissionBasis', 'studyForm', 'category', 'accept', 'original',
        'summ', 'indAchievement', 'summContest', 'needHostel', 'notice1', 'notice2'];

    public function student() {
        return $this->belongsTo(Student::class, 'id_student');
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
}
