<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyForms extends Model
{
    protected $fillable = ['name', 'price', 'budget', 'year', 'course_id'];

//    protected $casts = ['studyForm' => 'array'];

    public function course() {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
