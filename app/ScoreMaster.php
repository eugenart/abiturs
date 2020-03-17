<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScoreMaster extends Model
{
    protected $fillable = ['score', 'id_statistic', 'id_subject', 'priority'];

    public function statistic() {
        return $this->belongsTo(StatisticMaster::class, 'id_statistic');
    }

    public function subject() {
        return $this->belongsTo(Subject::class, 'id_subject');
    }
}
