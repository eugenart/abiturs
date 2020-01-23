<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingArea extends Model
{
    protected $fillable = ['id_speciality', 'trainingForm', 'freeSeatsNumber', 'years', 'price'];


    public function speciality() {
        return $this->belongsTo(Subject::class, 'id_speciality');
    }

    public function minScores() {
        return $this->hasMany(TrainingAreasSubject::class, 'id_area');
    }


    public function faculty() {
        return $this->hasOne(FacultyArea::class, 'id_area');
    }

}
