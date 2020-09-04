<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionSpo extends Model
{
    protected $fillable = ['competitionId', 'competitionName'];

    public function plans() {
        return $this->hasMany(PlanCompetitionSpo::class, 'id_competition');
    }
}
