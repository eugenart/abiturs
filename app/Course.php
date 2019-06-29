<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'parent_id', 'score'];

//    protected $casts = ['studyForm' => 'array'];

    public function parent() {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function subjects() {
        return $this->hasMany(Subject::class, 'course_id');
    }

    public function  studyForms() {
        return $this->hasMany(StudyForms::class, 'course_id');
    }
}
