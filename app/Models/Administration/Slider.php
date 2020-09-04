<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = ['name', 'url', 'priority', 'activity', 'activityFrom', 'activityTo', 'image', 'image_mobile','image_ipad', 'foreigner'];
}
