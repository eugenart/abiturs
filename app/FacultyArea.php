<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacultyArea extends Model
{
    protected $fillable = ['id_faculty', 'id_area'];

    public function faculty() {
        return $this->belongsTo(Faculty::class, 'id_faculty');
    }

    public function area() {
        return $this->belongsTo(TrainingArea::class, 'id_area');
    }
}
