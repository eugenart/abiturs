<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['name', 'url', 'description', 'startPage', 'startPagePriority', 'activity', 'activityFrom', 'activityTo', 'infoblockID', 'sectionID'];

    public function infoblock()
    {
        return $this->belongsTo('App\Infoblock', 'infoblockID');
    }

    public function parentSection()
    {
        return $this->belongsTo(self::class, 'sectionID');
    }

    public function childrenSections()
    {
        return $this->hasMany(self::class, 'sectionID');
    }
}
