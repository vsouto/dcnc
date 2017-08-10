<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Diligencia extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comarca_id','titulo','descricao','advogado_id','orgao','local_orgao','vara','num_integracao','num_processo',
        'prazo', 'tipo_id','reu','status_id','solicitante','orientacoes','correspondente_id','urgencia','autor','sondagem',
        'realizado_sucesso', 'realizador_nome','realizador_telefone','realizador_email','revisao_instrucoes', 'revisao_resolucao',
        'visited_by_correspondente','audiencia'
    ];

    protected $dates = ['created_at','updated_at','prazo','sondagem'];

    /**
     * Get the entity
     */
    public function advogado()
    {
        return $this->belongsTo('App\User', 'advogado_id');
    }

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
    public function correspondente()
    {
        return $this->belongsTo('App\Correspondente');
    }

    /**
     * Get the entity
     */
    public function files()
    {
        return $this->belongsToMany('App\File');
    }

    /**
     * Get the entity
     */
    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    /**
     * Get the entity
     */
    public function tipo()
    {
        return $this->belongsTo('App\Tipo');
    }

    /**
     * Get the entity
     */
    public function servicos()
    {
        return $this->belongsToMany('App\Servico');
    }

    /**
     * Get the entity
     */
    public function conclusao()
    {
        return $this->hasOne('App\Conclusao');
    }

    /**
     * Get the attribute
     *
     * @param  string  $value
     * @return string
     */
    public function getTotalAttribute($value)
    {
        return 'R$ 90';
    }

    /**
     * Get the current action needed to continue the flow
     *
     * @param $id
     * @return string
     */
    public static function getCurrentAction($id)
    {
        $diligencia = Diligencia::where('id',$id)->firstOrFail();

        if (!$diligencia || !$diligencia->status)
            return false;

        $button = 'Sem ações disponíveis no momento.';

        switch ($diligencia->status->slug) {
            case 'aguardando-confirmacao':
                $button = '<button type="button" class="btn btn-info btn-rounded acao-aceitar" id="acao-aceitar">Aceitar</button>';
                break;
            case 'em-negociacao':

                // Only for coordenadores
                if (Auth::user()->level >= 5) {
                    $button = '<div class="alert alert-warning alert-white rounded">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <div class="icon"><i class="fa fa-exclamation-triangle"></i></div>
                            <strong>Alerta!</strong> Você deve selecionar um Correspondente manualmente!
                        </div>';
                }
                break;
            case 'aguardando-checkin':
            case 'sem-checkin':

                $button = '<button type="button" class="btn btn-info btn-rounded" id="acao-checkin">Fazer CheckIn</button>';
                break;
            case 'aguardando-conclusao':

                $button = '<button type="button" class="btn btn-info btn-rounded" id="acao-concluir">Trabalho Concluído</button>';
                break;
            case 'devolvida':

                $button = '<button type="button" class="btn btn-info btn-rounded" id="acao-resolver-confirma">Resolvido</button>';
                break;
            case 'em-revisao':

                // Only for coordenadores ou clientes
                if (Auth::user()->level == 2 || Auth::user()->level >= 5) {
                    $button = '<button type="button" class="btn btn-info btn-rounded" id="acao-aprovar">Aprovar</button>';
                    $button .= ' <button type="button" class="btn btn-info btn-rounded" id="acao-devolver">Devolver</button>';
                }
                break;
            default:
                $button = 'Sem ações disponíveis no momento.';
        }

        return $button;
    }

    public static function isCurrentCorrespondente($diligencia)
    {
        if (!Auth::user()->correspondente_id || empty(Auth::user()->correspondente_id))
            return false;

        return $diligencia->correspondente_id == Auth::user()->correspondente_id? true : false;
    }


}
