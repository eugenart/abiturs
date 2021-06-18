<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAsp extends Model
{
    protected $fillable = ['studentId', 'fio', 'snils', 'snils2'];

    public function statistics() {
        return $this->hasMany(StatisticAsp::class, 'id_student');
    }
}
