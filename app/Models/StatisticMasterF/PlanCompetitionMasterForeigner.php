<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanCompetitionMasterForeigner extends Model
{
    protected $fillable = ['id_plan', 'id_competition', 'freeSeatsNumber'];

    public function plan() {
        return $this->belongsTo(PlanMasterForeigner::class, 'id_plan');
    }

    public function competition() {
        return $this->belongsTo(CompetitionMasterForeigner::class, 'id_competition');
    }

    public function scores() {
        return $this->hasMany(PlanCompScoreMasterForeigner::class, 'id_plan_comp');
    }

    public function freeseats() {
        return $this->hasMany(Freeseats_basesMasterForeigner::class, 'id_plan_comp');
    }

    public function prices() {
        return $this->hasMany(PriceMasterForeigner::class, 'id_plan_comp');
    }
}
