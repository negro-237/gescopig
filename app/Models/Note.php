<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class Note extends Model
{
    use RevisionableTrait;

    protected $revisionCreationsEnabled = true;
    protected $revisionForceDeleteEnabled = true;

    protected $fillable = [
        'enseignement_id',
        'contrat_id',
        'session1',
        'cc',
        'session2',
        'del1',
        'del2'
    ];

    public function enseignement(){
        return $this->belongsTo(Enseignement::class);
    }

    public function contrat(){
        return $this->belongsTo(Contrat::class);
    }
}
