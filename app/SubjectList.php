<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectList extends Model
{
    public function subjects() {
        return $this->hasMany(Subject::class, 'subject_id');
    }
}
