<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Infoblock extends Model
{
    protected $fillable = ['name', 'url', 'menu', 'menu_priority', 'start_page', 'start_page_priority'];
}
