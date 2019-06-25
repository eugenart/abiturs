<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'score', 'course_id'];

    public function subjects() {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
