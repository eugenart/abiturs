<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['studentId', 'fio'];

    public function statistics() {
        return $this->hasMany(Statistic::class, 'id_student');
    }
}
