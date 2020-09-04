<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Infoblock extends Model
{
    protected $fillable = ['name', 'url', 'menu', 'menuPriority', 'startPage', 'startPagePriority', 'activity', 'activityFrom', 'activityTo', 'image', 'news', 'foreigner'];

    protected $casts = ['news' => 'array'];

    public function sections() {
        return $this->hasMany(Section::class, 'infoblockID');
    }
}
