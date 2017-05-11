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
    protected $fillable = [];


    /**
     * Get the entity
     */
    public function correspondentes()
    {
        return $this->hasMany('App\Correspondente');
    }
}
