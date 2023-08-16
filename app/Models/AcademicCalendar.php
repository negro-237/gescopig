<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class AcademicCalendar extends Model
{
    use RevisionableTrait;

    protected $revisionCreationsEnabled = true;
    protected $revisionForceDeleteEnabled = true;

    protected $fillable = [
        'dateDebutPrevue',
        'dateDebut',
        'dateFinPrevue',
        'dateFin',
        'semestre_id',
        'academic_year_id'
    ];

    protected $casts = [
        'dateDebutPrevue' => 'date',
        'dateDebut' => 'date',
        'dateFinPrevue' => 'date',
        'dateFin' => 'date',
    ];

    public function semestre(){
        return $this->belongsTo(Semestre::class);
    }

    public function academicYear(){
        return $this->belongsTo(AcademicYear::class);
    }
}
