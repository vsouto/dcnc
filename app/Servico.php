<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * Get the entity
     */
    public function diligencias()
    {
        return $this->belongsToMany('App\Diligencia');
    }
}
