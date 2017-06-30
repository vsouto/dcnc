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
        return $this->belongsToMany('App\Servico')->withPivot(['valor','comarca_id']);
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

        return DB::select("SELECT c.id FROM correspondentes c
            JOIN correspondente_servico cs ON (cs.correspondente_id = c.id )
            JOIN servicos s ON (s.id = cs.servico_id)
                WHERE cs.valor > s.max
                GROUP BY c.id, cs.valor, s.max");

    }

    /**
     * Get Best Correspondente For a specific Diligencia/Servico
     *
     * @param $comarca_id
     * @return mixed
     */
    public static function getBestCorrespondenteForDiligencia($comarca_id,$servico_id)
    {
        $servico = Servico::where('id',$servico_id)->first();

        return DB::select("SELECT correspondente_id
            FROM correspondente_servico
                WHERE comarca_id = '$comarca_id' AND servico_id = '$servico_id' AND valor <= '{$servico->max}'
                    ORDER BY valor ASC");
    }

    /**
     * Get correspondentes recomendados para uma diligência
     * overprices inclusos
     *
     * @param $servico_id
     * @param $comarca_id
     * @return mixed
     */
    public static function getRecomendados($servico_id, $comarca_id)
    {
        return DB::select("SELECT c.id, c.nome, c.rating, cs.valor
                    FROM correspondentes c
                        JOIN correspondente_servico cs ON
                          (cs.correspondente_id = c.id AND cs.servico_id = $servico_id AND cs.comarca_id = $comarca_id)
                            GROUP BY c.id, c.nome, cs.valor, c.rating
                            ORDER BY cs.valor ASC
                                 ");
    }

}
