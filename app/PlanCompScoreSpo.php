<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanCompScoreSpo extends Model
{
    protected $fillable = ['id_plan_comp', 'id_subject', 'minScore'];

    public function plan_comp() {
        return $this->belongsTo(PlanCompetitionSpo::class, 'id_plan_comp');
    }

    public function subject() {
        return $this->belongsTo(Subject::class, 'id_subject');
    }
}
