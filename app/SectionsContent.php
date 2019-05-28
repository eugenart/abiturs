<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionsContent extends Model
{
    protected $fillable = ['name', 'position', 'content', 'type', 'section_id', 'parent_id'];
}
