<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public static function setupAndFire($user_receiver_id, $mail, Array $data = [])
    {

        Email::create([
            'titulo' => 'Email ' . $mail . ' para ' . $user_receiver_id,
            'user_id' => $user_receiver_id,
            'descricao' => $mail,
            'file' => $mail
        ]);

        switch ($mail) {
            case 'correspondente.create':

                break;
            case 'cliente.create':

                break;
            case 'diligencia.a1':


                break;
            case 'diligencia.a2':


                break;
            case 'diligencia.conclusao':

                break;

            default:
                break;
        }
    }
}
