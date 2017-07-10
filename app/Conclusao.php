<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conclusao extends Model
{
    //


    /**
     * Get the entity
     */
    public function diligencia()
    {
        return $this->belongsTo('App\Diligencia');
    }
}
