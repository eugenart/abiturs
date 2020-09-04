<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceMaster extends Model
{
    protected $fillable = ['id_plan_comp', 'price', 'info'];

    public function plan_comp() {
        return $this->belongsTo(PlanCompetitionMaster::class, 'id_plan_comp');
    }
}
