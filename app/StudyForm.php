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

    public function plan()
    {
        return $this->hasMany(Plan::class, 'id_studyForm');
    }

    public function pastContests()
    {
        return $this->hasMany(PastContests::class, 'id_studyForm');
    }
}
