<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['score', 'course_id', 'subject_id'];

    public function course() {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function subjectsList() {
        return $this->belongsTo(SubjectList::class, 'subject_id');
    }
}
