<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Cliente extends Model
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
    protected $fillable = ['nome','slug','email','endereco','phone','user_id'];

    /**
     * Get the entity
     */
    public function advogados()
    {
        return $this->hasMany('App\User');
    }

    /**
     * Get the entity
     */
    public function admin()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
