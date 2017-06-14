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
    protected $fillable = ['comarca','uf'];


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

    public static function getList()
    {
        return Comarca::get()->toArray();
    }

    public static function getEstadosList()
    {
        return Comarca::whereNotNull('uf')
                ->groupBy('uf')
                ->orderBy('uf','ASC')
                ->pluck('uf','uf');
    }
}
