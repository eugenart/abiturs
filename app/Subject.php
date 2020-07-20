<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['subjectId', 'name', 'en_name'];

    public function scores() {
        return $this->hasMany(Score::class, 'id_subject');
    }
    //больше не нужно
    public function areas() {
        return $this->hasMany(Score::class, 'id_subject');
    }

    public function plan_scores() {
        return $this->hasMany(PlanCompScore::class, 'id_subject');
    }
}
