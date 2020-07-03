<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanCompetitionForeigner extends Model
{
    protected $fillable = ['id_plan', 'id_competition', 'freeSeatsNumber'];

    public function plan() {
        return $this->belongsTo(PlanForeigner::class, 'id_plan');
    }

    public function competition() {
        return $this->belongsTo(CompetitionForeigner::class, 'id_competition');
    }

    public function scores() {
        return $this->hasMany(PlanCompScoreForeigner::class, 'id_plan_comp');
    }

    public function freeseats() {
        return $this->hasMany(Freeseats_basesForeigner::class, 'id_plan_comp');
    }

    public function prices() {
        return $this->hasMany(PriceForeigner::class, 'id_plan_comp');
    }
}
