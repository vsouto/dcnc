<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'level', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Get the entity
     */
    public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }

    /**
     * Get the entity
     */
    public function files()
    {
        return $this->hasMany('App\File');
    }

    /**
     * Get the entity
     */
    public function correspondente()
    {
        return $this->belongsTo('App\Correspondente');
    }


}
