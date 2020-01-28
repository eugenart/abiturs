<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmissionBasis extends Model
{
    protected $fillable = ['name'];

    public function statistics() {
        return $this->hasMany(Statistic::class, 'id_admissionBasis');
    }
}
