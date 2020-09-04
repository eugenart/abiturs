<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionMaster extends Model
{
    protected $fillable = ['competitionId', 'competitionName'];

    public function plans() {
        return $this->hasMany(PlanCompetitionMaster::class, 'id_competition');
    }
}
