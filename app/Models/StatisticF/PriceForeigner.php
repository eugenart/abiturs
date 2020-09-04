<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceForeigner extends Model
{
    protected $fillable = ['id_plan_comp', 'price', 'info'];

    public function plan_comp() {
        return $this->belongsTo(PlanCompetitionForeigner::class, 'id_plan_comp');
    }
}
