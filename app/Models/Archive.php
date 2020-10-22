<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    protected $fillable = ['name'];

    public function infoblocks() {
        return $this->belongsToMany('App\Infoblock', 'archive_infoblocks', 'id_archive', 'id_infoblock');
    }
}
