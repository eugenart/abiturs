<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Freeseats_basesAsp extends Model
{
    protected $fillable = ['id_plan_comp', 'id_admissionBasis', 'value'];

    public function plan_comp() {
        return $this->belongsTo(PlanCompetitionAsp::class, 'id_plan_comp');
    }

    public function admissionBasis() {
        return $this->belongsTo(AdmissionBasis::class, 'id_admissionBasis');
    }
}
