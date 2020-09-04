<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionMasterForeigner extends Model
{
    protected $fillable = ['competitionId', 'competitionName'];

    public function plans() {
        return $this->hasMany(PlanCompetitionMasterForeigner::class, 'id_competition');
    }
}
