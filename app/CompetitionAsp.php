<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionAsp extends Model
{
    protected $fillable = ['competitionId', 'competitionName'];

    public function plans() {
        return $this->hasMany(PlanCompetitionAsp::class, 'id_competition');
    }
}
