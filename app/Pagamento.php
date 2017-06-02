<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'authorized_id','receiver_id','diligencia_id','efetivada','valor','tipo'
    ];
}
