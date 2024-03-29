<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmissionBasis extends Model
{
    protected $fillable = ['name', 'en_name'];

    public function statistics() {
        return $this->hasMany(Statistic::class, 'id_admissionBasis');
    }
    public function freeseats() {
        return $this->hasMany(Freeseats_bases::class, 'id_admissionBasis');
    }
    public function freeseats_foreigner() {
        return $this->hasMany(Freeseats_basesForeigner::class, 'id_admissionBasis');
    }

    public function pastContests()
    {
        return $this->hasMany(PastContests::class, 'id_studyForm');
    }
}
