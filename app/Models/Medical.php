<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medical extends Model
{

    protected $dates = ['created_at'];

    public $fillable = [
        'student_id',
        'academic_id',
        'advice',
        'symptoms',
        'first_aid'
    ];

    public function student() {
        return $this->belongsTo(Apprenant::class);
    }

    public function academic() {
        return $this->belongsTo(AcademicYear::class);
    }

}
