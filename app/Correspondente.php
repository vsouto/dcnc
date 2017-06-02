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
        return $this->belongsToMany('App\Servico')->withPivot('valor', 'comarca_id');
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

        /*
         * SELECT c.id, c.nome , cs.valor, s.max
	FROM correspondentes c
		JOIN correspondente_servico cs ON (cs.correspondente_id = c.id )
		JOIN servicos s ON (s.id = cs.servico_id)
			WHERE cs.valor > s.max
			GROUP BY c.id, cs.valor, s.max
         */
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
        $correspondente = Correspondente::
            with('comarcas')
            ->with('servicos')
            ->whereHas('comarcas', function ($query) use ($comarca_id) {
                $query->where('comarcas.id',$comarca_id);
            })
            ->has('servicos',$servico_id)
            ->orderBy('rating','DESC')
            ->first();

        return $correspondente;
    }
}
