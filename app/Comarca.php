<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comarca extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['comarca'];


    /**
     * Get the entity
     */
    public function correspondentes()
    {
        return $this->belongsToMany('App\Correspondente');
    }

    /**
     * Get the entity
     */
    public function diligencias()
    {
        return $this->hasMany('App\Diligencia');
    }
}
