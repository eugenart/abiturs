<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Infoblock extends Model
{
    protected $fillable = ['name', 'url', 'menu', 'menuPriority', 'startPage', 'startPagePriority', 'activity', 'activityFrom', 'activityTo'];
}
