<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'tel',
        'position',
        'email',
        'sdu_id',
        'password',
        'role',
        'facebook_token',
        'avatar'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    
    public function admin()
    {
        return strcasecmp($this->role, 'admin') == 0;
    }
}
