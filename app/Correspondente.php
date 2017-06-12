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
    public function comarcas()
    {
        return $this->belongsToMany('App\Comarca');
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
     * @param $query
     * @return mixed
     */
    public function scopeOverprice($query, $reverse = false)
    {
        if (!$reverse)
            return $query->select(DB::raw('DISTINCT(correspondentes.id)'))
                ->join('correspondente_servico', 'correspondente_servico.correspondente_id','=','correspondentes.id')
                ->join('servicos', 'servicos.id','=','correspondente_servico.servico_id')
                ->where('correspondente_servico.valor','>','servicos.max')
                ->groupBy('correspondentes.id', 'correspondente_servico.valor', 'servicos.max');

        else
        /*
            return $query->select(DB::raw('DISTINCT(correspondentes.id)'))
                ->join('correspondente_servico', 'correspondente_servico.correspondente_id','=','correspondentes.id')
                ->join('servicos', 'servicos.id','=','correspondente_servico.servico_id')
                ->where('correspondente_servico.valor','<','servicos.max')
                ->groupBy('correspondentes.id', 'correspondente_servico.valor', 'servicos.max');*/


        return DB::select("SELECT c.id FROM correspondentes c
            JOIN correspondente_servico cs ON (cs.correspondente_id = c.id )
            JOIN servicos s ON (s.id = cs.servico_id)
                WHERE cs.valor > s.max
                GROUP BY c.id, cs.valor, s.max");

    }

    /**
     * Get Best Correspondente For Diligencia
     *
     * @param $comarca_id
     * @return mixed
     */
    public static function getBestCorrespondenteForDiligencia($comarca_id,$servico_id)
    {
        $servico = Servico::where('id',$servico_id)->first();

        return DB::select("SELECT c.id, c.nome, cs.valor FROM correspondentes c
                JOIN comarca_correspondente cc ON (cc.correspondente_id = c.id AND cc.comarca_id = $comarca_id)
                JOIN correspondente_servico cs ON (cs.correspondente_id = c.id AND cs.servico_id = 1 AND cs.valor < $servico->max)
                  GROUP BY cs.valor, c.id
                    ORDER BY cs.valor ASC, c.rating DESC
                    LIMIT 1

		");

    }
}
