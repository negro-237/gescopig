<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class Corkage extends Model
{
    use RevisionableTrait;

    protected $revisionCreationsEnabled = true;
    protected $revisionForceDeleteEnabled = true;
    
    protected $fillable = [
        'title',
        'montant',
        'reduction',
        'contrat_id'
    ];

    public function contrat(){
        return $this->belongsTo(Contrat::class);
    }
}
