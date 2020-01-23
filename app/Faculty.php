<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = ['facultyId', 'name'];

    public function statistics() {
        return $this->hasMany(Statistic::class, 'id_faculty');
    }

    public function areas() {
        return $this->hasMany(FacultyArea::class, 'id_faculty');
    }

}
