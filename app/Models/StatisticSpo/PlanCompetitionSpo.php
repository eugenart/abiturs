<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanCompetitionSpo extends Model
{
    protected $fillable = ['id_plan', 'id_competition', 'freeSeatsNumber'];

    public function plan() {
        return $this->belongsTo(PlanSpo::class, 'id_plan');
    }

    public function competition() {
        return $this->belongsTo(CompetitionSpo::class, 'id_competition');
    }

    public function scores() {
        return $this->hasMany(PlanCompScoreSpo::class, 'id_plan_comp');
    }

    public function freeseats() {
        return $this->hasMany(Freeseats_basesSpo::class, 'id_plan_comp');
    }

    public function prices() {
        return $this->hasMany(PriceSpo::class, 'id_plan_comp');
    }
}
