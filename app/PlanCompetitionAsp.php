<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanCompetitionAsp extends Model
{
    protected $fillable = ['id_plan', 'id_competition', 'freeSeatsNumber'];

    public function plan() {
        return $this->belongsTo(PlanAsp::class, 'id_plan');
    }

    public function competition() {
        return $this->belongsTo(CompetitionAsp::class, 'id_competition');
    }

    public function scores() {
        return $this->hasMany(PlanCompScoreAsp::class, 'id_plan_comp');
    }

    public function freeseats() {
        return $this->hasMany(Freeseats_basesAsp::class, 'id_plan_comp');
    }

    public function prices() {
        return $this->hasMany(PriceAsp::class, 'id_plan_comp');
    }
}
