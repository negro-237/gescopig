<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class Moratoire extends Model
{
    use RevisionableTrait;

    protected $revisionCreationsEnabled = true;
    protected $revisionForceDeleteEnabled = true;

    protected $fillable = [
        'contrat_id',
        'montant',
        'date',
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function contrat(){
        return $this->belongsTo(Contrat::class);
    }

}
