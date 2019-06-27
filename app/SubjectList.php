<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectList extends Model
{
    protected $fillable = ['name', 'internal'];

    protected $casts = ['internal' => 'boolean'];

    public function subjects() {
        return $this->hasMany(Subject::class, 'subject_id');
    }
}
