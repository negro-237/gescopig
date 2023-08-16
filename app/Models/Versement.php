<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class Versement extends Model
{
    use RevisionableTrait;

    protected $revisionCreationsEnabled = true;
    protected $revisionForceDeleteEnabled = true;
    
    protected $fillable =[
        'contrat_id',
        'montant',
        'motif',
    ];

    public function contrat(){
        return $this->belongsTo(Contrat::class);
    }
}
