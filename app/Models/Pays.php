<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use \Venturecraft\Revisionable\RevisionableTrait;

class Pays extends Model
{
    use SoftDeletes;
    //use RevisionableTrait;

    //protected $revisionCreationsEnabled = true;
    //protected $revisionForceDeleteEnabled = true;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public $fillable = [
        'nom',
        'code',
    ];

}
