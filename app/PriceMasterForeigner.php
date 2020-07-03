<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceMasterForeigner extends Model
{
    protected $fillable = ['id_plan_comp', 'price', 'info'];

    public function plan_comp() {
        return $this->belongsTo(PlanCompetitionMasterForeigner::class, 'id_plan_comp');
    }
}
