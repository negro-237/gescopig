<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
//use \Venturecraft\Revisionable\RevisionableTrait;

class User extends Authenticatable
{
    use Notifiable, HasRoles;
    //use RevisionableTrait;

    protected $revisionCreationsEnabled = true;
    protected $revisionForceDeleteEnabled = true;
    /*
    protected $dontKeepRevisionOf = ['password', 'updated_at'];
    protected $revisionNullString = 'nothing';
    protected $revisionUnknowString = 'unknown';
    protected $revisionFormattedFields = [
        'name'      => 'string:<strong>%s</strong>',
        'created_at' => 'datetime:m/d/Y g:i A',
        'deleted_at' => 'isEmpty:Active|Inactive'
    ];
    protected $revisionFormattedFieldNames = [
        'name'      => 'Name',
        'email' => 'Email ID',
        'deleted_at' => 'Active status',
        'updated_at' => 'Updated at'
    ];

    public function identifiableName(){
        return $this->name;
    }
    */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'last_login_at', 'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function setPasswordAttribute($password){
        $this->attributes['password'] = bcrypt($password);
    }

}
