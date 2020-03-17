<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentSpo extends Model
{
    protected $fillable = ['studentId', 'fio'];

    public function statistics() {
        return $this->hasMany(StatisticSpo::class, 'id_student');
    }
}
