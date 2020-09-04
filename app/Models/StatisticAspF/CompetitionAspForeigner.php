<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionAspForeigner extends Model
{
    protected $fillable = ['competitionId', 'competitionName'];

    public function plans() {
        return $this->hasMany(PlanCompetitionAspForeigner::class, 'id_competition');
    }
}
