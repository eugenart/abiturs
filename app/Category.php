<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'en_name'];

    public function statistics() {
        return $this->hasMany(Statistic::class, 'id_category');
    }
}
