<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $fillable = ['competitionId', 'competitionName'];

    public function plans() {
        return $this->hasMany(PlanCompetition::class, 'id_competition');
    }

}
