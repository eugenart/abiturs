<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PastContests extends Model
{
    protected $fillable = ['id_studyForm', 'id_admissionBasis', 'id_speciality', 'year', 'minScore'];

    public function studyForm() {
        return $this->belongsTo(StudyForm::class, 'id_studyForm');
    }
    public function admissionBasis() {
        return $this->belongsTo(AdmissionBasis::class, 'admissionBasis');
    }
    public function speciality() {
        return $this->belongsTo(Speciality::class, 'id_speciality');
    }
}
