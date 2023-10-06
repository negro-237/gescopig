<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use \Venturecraft\Revisionable\RevisionableTrait;

class Contrat extends Model
{

    use softDeletes;
    //use RevisionableTrait;

    protected $revisionCreationsEnabled = true;
    protected $revisionForceDeleteEnabled = true;

    public $table = 'contrats';


    protected $dates = ['deleted_at'];

    protected $fillable = [
        'apprenant_id',
        'specialite_id',
        'cycle_id',
        'type',
        'state',
        'inscription_status',
        'academic_year_id',
        'ville_id',
        'dette',
        'moratoire'
    ];

    protected $casts = [
        'apprenant_id' => 'bail|required|integer',
        'cycle_id' => 'bail|required|integer',
        'specialite_id' => 'bail|required|integer',
        'ville_id' => 'bail|required|integer',
    ];

    public static $rules = [
        'apprenant_id' => 'bail|required|integer',
        'cycle_id' => 'bail|required|integer',
        'specialite_id' => 'bail|required|integer',
        'academic_year_id' => 'bail|required',
        'ville_id' => 'bail|required',
    ];

    public function apprenant(){
        return $this->belongsTo(Apprenant::class);
    }

    public function specialite(){
        return $this->belongsTo(Specialite::class);
    }

    public function cycle(){
        return $this->belongsTo(Cycle::class);
    }

    public function academic_year(){
        return $this->belongsTo(AcademicYear::class);
    }

    public function absences()
    {
        return $this->hasMany(\App\Models\Absence::class);
    }

    public function ingoing(){
        return $this->morphOne(Ingoing::class, 'ingoing');
    }

    public function notes() {
        return $this->hasMany(Note::class);
    }

    public function ue_infos(){
        return $this->hasMany(UeInfo::class);
    }

    public function semestre_infos(){
        return $this->hasMany(SemestreInfo::class);
    }

    public function moratoires(){
        return $this->hasMany(Moratoire::class);
    }

    public function versements(){
        return $this->hasMany(Versement::class);
    }

    public function resultatNominatifs(){
        return $this->hasMany(ResultatNominatif::class);
    }

    public function autorisation(){
        return $this->hasOne(Autorisation::class);
    }

    public function attestation(){
        return $this->hasOne(Attestation::class);
    }

    public function certificat(){
        return $this->hasOne(Certificat::class);
    }

    public function preinscription(){
        return $this->hasOne(Preinscription::class);
    }

    public function inscription(){
        return $this->hasOne(Inscription::class);
    }

    public function corkages(){
        return $this->hasMany(Corkage::class);
    }

    public function ville(){
        return $this->belongsTo(Ville::class);
    }
}
