<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanCompetitionMaster extends Model
{
    protected $fillable = ['id_plan', 'id_competition', 'freeSeatsNumber'];

    public function plan() {
        return $this->belongsTo(PlanMaster::class, 'id_plan');
    }

    public function competition() {
        return $this->belongsTo(CompetitionMaster::class, 'id_competition');
    }

    public function scores() {
        return $this->hasMany(PlanCompScoreMaster::class, 'id_plan_comp');
    }

    public function freeseats() {
        return $this->hasMany(Freeseats_basesMaster::class, 'id_plan_comp');
    }

    public function prices() {
        return $this->hasMany(PriceMaster::class, 'id_plan_comp');
    }
}
