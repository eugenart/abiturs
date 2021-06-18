<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentMasterForeigner extends Model
{
    protected $fillable = ['studentId', 'fio', 'snils', 'snils2'];

    public function statistics() {
        return $this->hasMany(StatisticMasterForeigner::class, 'id_student');
    }
}
