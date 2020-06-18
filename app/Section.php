<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['name', 'url', 'description', 'startPage', 'startPagePriority', 'activity', 'activityFrom', 'activityTo', 'infoblockID', 'sectionID', 'isFolder', 'real_link'];

    public function infoblock() {
        return $this->belongsTo(Infoblock::class, 'infoblockID');
    }

    public function parentSection() {
        return $this->belongsTo(self::class, 'sectionID');
    }

    public function childrenSections() {
        return $this->hasMany(self::class, 'sectionID');
    }

    public function sectionContent() {
        return $this->hasMany(SectionsContent::class, 'section_id');
    }
}
