<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    protected $fillable = ['specialityId','code', 'name'];

    public function statistics() {
        return $this->hasMany(Statistic::class, 'id_speciality');
    }
    public function area()
    {
        return $this->hasOne(TrainingArea::class, 'id_speciality');
    }
}
