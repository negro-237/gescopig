<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class ContratEnseignant extends Model
{
    use RevisionableTrait;

    protected $revisionCreationsEnabled = true;
    protected $revisionForceDeleteEnabled = true;
    
    protected $fillable = [
        'enseignant_id',
        'academic_year_id',
        'mh_licence',
        'mh_master',
        'rang',
        'ville_id',
    ];

    public static $rules = [
        'montant' => 'bail|required|integer',
        'date' => 'bail|required|date',
        'tranche' => 'bail|required',
        'numero_piece' => 'bail|required',
        'ecue_id' => 'bail|required|integer',
        'specialite' => 'bail|required',
        'ville_id' => 'bail|required|integer',
    ];

    public function enseignant(){
        return $this->belongsTo(Enseignant::class);
    }

    public function academic_year(){
        return $this->belongsTo(AcademicYear::class);
    }

    public function enseignements()
    {
        return $this->hasMany(\App\Models\Enseignement::class);
    }

    public function payments(){
        return $this->hasMany(TeacherPay::class);
//        return $this->morphMany(TeacherPay::class, 'teachable');
    }

    public function ville(){
        return $this->belongsTo(Ville::class);
    }
}
