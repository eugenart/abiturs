<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DateUpdate extends Model
{
    protected $fillable = ['name_file', 'date_update', 'username'];
}
