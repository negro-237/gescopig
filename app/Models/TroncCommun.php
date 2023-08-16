<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class TroncCommun extends Model
{
    use RevisionableTrait;

    protected $revisionCreationsEnabled = true;
    protected $revisionForceDeleteEnabled = true;
    
    public function enseignements(){
        return $this->hasMany(Enseignement::class);
    }

    public function payments(){
        return $this->morphMany(TeacherPay::class, 'teachable');
    }
}
