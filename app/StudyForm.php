<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyForm extends Model
{
    protected $fillable = ['name'];

    public function statistics()
    {
        return $this->hasMany(Statistic::class, 'id_studyForm');
    }
    //больше не нужно
    public function area()
    {
        return $this->hasMany(TrainingArea::class, 'id_studyForm');
    }

    public function plan()
    {
        return $this->hasMany(Plan::class, 'id_studyForm');
    }
}
