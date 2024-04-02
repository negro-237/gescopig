<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class UeInfo extends Model
{
    //use RevisionableTrait;

    //protected $revisionCreationsEnabled = true;
    //protected $revisionForceDeleteEnabled = true;
    
    protected $fillable = [
        'ue_id',
        'contrat_id',
        'creditTot',
        'creditObt',
        'moyenne',
        'mention',
        'totalNotes'
    ];

    public function ue(){
        return $this->belongsTo(Ue::class);
    }

    public function contrat(){
        return $this->belongsTo(Contrat::class);
    }
}
