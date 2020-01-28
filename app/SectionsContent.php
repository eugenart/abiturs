<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionsContent extends Model
{
    protected $fillable = ['name', 'position', 'content', 'type', 'section_id', 'parent_id', 'vmodel', 'file_name', 'ext_file'];

    public function section() {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function childrenFiles() {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parentBlock() {
        return $this->hasMany(self::class, 'parent_id');
    }
}
