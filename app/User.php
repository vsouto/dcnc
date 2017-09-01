<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'email', 'password', 'level', 'phone','correspondente_id','endereco','avatar','cliente_id','token','ativo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static $levels = [
        '3' => 'Operador',
        '4' => 'Negociador',
        '5' => 'Coordenador',
        '6' => 'Financeiro',
        '9' => 'Admin',
    ];

    /**
     * Get the entity
     */
    public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }

    /**
     * Get the entity
     */
    public function files()
    {
        return $this->hasMany('App\File');
    }

    /**
     * Get the entity
     */
    public function correspondente()
    {
        return $this->belongsTo('App\Correspondente');
    }

    /**
     * Scope a query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdvogado($query)
    {
        return $query->whereNotNull('cliente_id');
    }

    public static function getAdvogadosList()
    {
        $advogados = User::advogado()
            ->join('clientes', 'clientes.id', '=', 'users.cliente_id')
            ->select('users.id','clientes.nome as empresa','users.nome as nome')
            ->get();

        $list = [];

        foreach ($advogados as $advogado) {
            $list[$advogado['id']] = $advogado['empresa'] . ' - ' . $advogado['nome'];
        }

        $default_option = ['0' => 'Selecione uma opção'];

        $list = $default_option + $list;

        return $list;
    }
}
