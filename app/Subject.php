<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['subjectId', 'name'];

    public function scores() {
        return $this->hasMany(Score::class, 'id_subject');
    }
}
