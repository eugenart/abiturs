<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceAsp extends Model
{
    protected $fillable = ['id_plan_comp', 'price', 'info'];

    public function plan_comp() {
        return $this->belongsTo(PlanCompetitionAsp::class, 'id_plan_comp');
    }
}
