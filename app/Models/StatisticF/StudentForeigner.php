<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentForeigner extends Model
{
    protected $fillable = ['studentId', 'fio', 'snils', 'snils2'];

    public function statistics() {
        return $this->hasMany(StatisticForeigner::class, 'id_student');
    }
}
