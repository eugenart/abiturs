<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionForeigner extends Model
{
    protected $fillable = ['competitionId', 'competitionName'];

    public function plans() {
        return $this->hasMany(PlanCompetitionForeigner::class, 'id_competition');
    }
}
