<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentMaster extends Model
{
    protected $fillable = ['studentId', 'fio'];

    public function statistics() {
        return $this->hasMany(StatisticMaster::class, 'id_student');
    }
}
