<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAspForeigner extends Model
{
    protected $fillable = ['studentId', 'fio', 'snils', 'snils2'];

    public function statistics() {
        return $this->hasMany(StatisticAspForeigner::class, 'id_student');
    }
}
