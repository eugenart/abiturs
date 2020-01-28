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

    public function area()
    {
        return $this->hasMany(TrainingArea::class, 'id_studyForm');
    }
}
