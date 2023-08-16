<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class Ue extends Model
{
    use RevisionableTrait;

    protected $revisionCreationsEnabled = true;
    protected $revisionForceDeleteEnabled = true;
    
    protected $fillable = [
        'title',
        'code',
        'cat_ue_id'
    ];

    public function cat_ue(){
        return $this->belongsTo(CatUe::class);
    }

    public function enseignments(){
        return $this->hasMany(Enseignement::class);
    }

    public function notes(){
        return $this->hasManyThrough(Note::class, Enseignement::class);
    }

    public function ue_infos(){
        return $this->hasMany(UeInfo::class);
    }
}
