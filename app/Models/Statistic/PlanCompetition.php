<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanCompetition extends Model
{
    protected $fillable = ['id_plan', 'id_competition', 'freeSeatsNumber'];

    public function plan() {
        return $this->belongsTo(Plan::class, 'id_plan');
    }

    public function competition() {
        return $this->belongsTo(Competition::class, 'id_competition');
    }

    public function scores() {
        return $this->hasMany(PlanCompScore::class, 'id_plan_comp');
    }

    public function freeseats() {
        return $this->hasMany(Freeseats_bases::class, 'id_plan_comp');
    }

    public function prices() {
        return $this->hasMany(Price::class, 'id_plan_comp');
    }
}
