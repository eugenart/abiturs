<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanCompetitionAspForeigner extends Model
{
    protected $fillable = ['id_plan', 'id_competition', 'freeSeatsNumber'];

    public function plan() {
        return $this->belongsTo(PlanAspForeigner::class, 'id_plan');
    }

    public function competition() {
        return $this->belongsTo(CompetitionAspForeigner::class, 'id_competition');
    }

    public function scores() {
        return $this->hasMany(PlanCompScoreAspForeigner::class, 'id_plan_comp');
    }

    public function freeseats() {
        return $this->hasMany(Freeseats_basesAspForeigner::class, 'id_plan_comp');
    }

    public function prices() {
        return $this->hasMany(PriceAspForeigner::class, 'id_plan_comp');
    }
}
