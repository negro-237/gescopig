<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class ResultatNomimatif extends Model
{
    use RevisionableTrait;

    protected $revisionCreationsEnabled = true;
    protected $revisionForceDeleteEnabled = true;
    
    protected $fillable = [
        'contrat_id',
        'next_cycle_id',
        'decision'
    ];

    public function contrat(){
        return $this->belongsTo(Contrat::class);
    }

    public  function cycle(){
        return $this->belongsTo(Cycle::class,'next_cycle_id');
    }
}
