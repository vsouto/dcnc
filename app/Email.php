<?php

namespace App;

use App\Mail\CheckinCobranca;
use App\Mail\CheckinFeito;
use App\Mail\DiligenciaAtrasada;
use App\Mail\DiligenciaCancelada;
use App\Mail\DiligenciaConfirmada;
use App\Mail\DiligenciaDevolvida;
use App\Mail\DiligenciaEfetivada;
use App\Mail\DiligenciaEmRevisao;
use App\Mail\DiligenciaPagamentoAutorizado;
use App\Mail\NovoAdvogado;
use App\Mail\NovoCorrespondente;
use App\Mail\SondagemConfirmation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Email extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','titulo','descricao','file'];

    /**
     * Get the entity
     */
    public function user()
    {
        return $this->belongsTo('App\User'); // Receiver
    }


    /**
     * Setup email and fire
     *
     * @param $type
     * @param array $user
     * @param Diligencia|null $diligencia
     * @return bool|void
     */
    public static function setupAndFire($type, Array $user, Diligencia $diligencia = null)
    {
        $result = false;

        if (!$user || !is_array($user))
            return abort('503', 'Must be array');

        // TODO: REMOVE
        $user = User::where('id','5')->first();
        //$user = User::where($user['type'],$user['id'])->first();

        if (!$user)
            return false;

        if (!$diligencia) {
            $description = 'Email ' . $type . ' para ' . $user->id . ' - ' . $user->nome;

            Email::create([
                'titulo' => 'Email para ' . $user->id . ' - ' . $user->nome,
                'user_id' => $user->id,
                'descricao' => $description,
                'file' => $type
            ]);
        }
        else {
            $description = 'Email [' . $type . '] sobre diligência ' . $diligencia->id . ' para: ' . $user->id . ' - ' . $user->nome;

            Email::create([
                'titulo' => 'Email ' . $type . ' sobre diligência '. $diligencia->id,
                'user_id' => $user->id,
                'descricao' => $description,
                'file' => $type
            ]);
        }


        switch ($type) {
            case 'A_1':
            case 'A_2':
            case 'A_3':

                $result = Mail::to($user)->send(new SondagemConfirmation($user, $diligencia, $description, $type));

                break;
            case 'B_1':
            case 'B_2':

                $result = Mail::to($user)->send(new DiligenciaConfirmada($user, $diligencia, $description, $type));

                break;
            case 'C_1':
            case 'C_2':

                $result = Mail::to($user)->send(new CheckinCobranca($user, $diligencia, $description, $type));
                break;
            case 'C_3':
            case 'C_4':

                $result = Mail::to($user)->send(new CheckinFeito($user, $diligencia, $description, $type));

                break;
            case 'T_1':
            case 'T_2':

                $result = Mail::to($user)->send(new DiligenciaAtrasada($user, $diligencia, $description, $type));

                break;
            case 'R_1':

                $result = Mail::to($user)->send(new DiligenciaEmRevisao($user, $diligencia, $description));
                break;
            case 'D_1':
            case 'D_2':

                $result = Mail::to($user)->send(new DiligenciaDevolvida($user, $diligencia, $description, $type));

                break;
            case 'D_3':

                $result = Mail::to($user)->send(new DiligenciaEmRevisao($user, $diligencia, $description));

                break;
            case 'X_1':
            case 'X_2':

                $result = Mail::to($user)->send(new DiligenciaCancelada($user, $diligencia, $description, $type));

                break;
            case 'P_1':
            case 'P_2':

                $result = Mail::to($user)->send(new DiligenciaPagamentoAutorizado($user, $diligencia, $description));

                break;
            case 'Z_1':
            case 'Z_2':

                $result = Mail::to($user)->send(new DiligenciaEfetivada($user, $diligencia, $description));

                break;
            case 'F_1':

                $result = Mail::to($user)->send(new NovoCorrespondente($user, $description));

                break;
            case 'F_2':

                $result = Mail::to($user)->send(new NovoAdvogado($user, $description));

                break;
            case 'F_3':

                $result = Mail::to($user)->send(new NovoCorrespondente($user, $description));

                break;
            default:
                break;
        }

        return $result;
    }
}
