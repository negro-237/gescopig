<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class Tutor extends Model
{
    use RevisionableTrait;

    protected $revisionCreationsEnabled = true;
    protected $revisionForceDeleteEnabled = true;
    
    protected $fillable = [
        'name',
        'profession',
        'addresse',
        'tel_mobile',
        'tel_bureau',
        'tel_fixe',
        'type',
        'apprenant_id'
    ];

    public function apprenant(){

        return $this->belongsTo(Apprenant::class);

    }
}
