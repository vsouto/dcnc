<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Correspondente extends Model
{
    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'nome'
            ]
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];


    /**
     * Get the entity
     */
    public function comarca()
    {
        return $this->belongsTo('App\Comarca');
    }

    /**
     * Get the entity
     */
    public function diligencias()
    {
        return $this->hasMany('App\Diligencia');
    }

    /**
     * Get the entity
     */
    public function servicos()
    {
        return $this->belongsToMany('App\Servico')->withPivot('valor','max');
    }

    /**
     * Get the entity
     */
    public function user()
    {
        return $this->hasOne('App\User');
    }

}
