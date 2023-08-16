<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalExam extends Model
{
    public $table = 'medical_exams';

    public $fillable = [
        'date_examen',
        'signes_symptomes',
        'premiers_soins',
        'avis_infirmier,',
        'apprenant_id'
    ];

    public function apprenant(){
        return $this->belongsTo(Apprenant::class);
    }
}
