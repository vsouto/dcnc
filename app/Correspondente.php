<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\DB;

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
    protected $fillable = ['nome','rating','comarca_id','slug'];


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
        return $this->belongsToMany('App\Servico')->withPivot('valor');
    }

    /**
     * Get the entity
     */
    public function user()
    {
        return $this->hasOne('App\User');
    }

    /**
     * Get Best Correspondente For Diligencia
     *
     * @param $comarca_id
     * @return mixed
     */
    public static function getBestCorrespondenteForDiligencia($comarca_id,$servico_id)
    {
        // Busca o correspondente desta comarca, de maior rating e de menor valor do serviço
        $correspondente = Correspondente::where('comarca_id',$comarca_id)
            ->with('servicos')
            ->has('servicos',$servico_id)
            ->orderBy('rating','DESC')
            ->first();

        return $correspondente;
    }
}
