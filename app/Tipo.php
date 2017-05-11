<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    //

    /**
     * Get the entity
     */
    public function status()
    {
        return $this->hasMany('App\Diligencia');
    }


    public static function getList()
    {
        return Tipo::pluck('tipo','id')->toArray();
    }
}
