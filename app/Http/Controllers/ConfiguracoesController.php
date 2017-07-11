<?php

namespace App\Http\Controllers;

use App\Configuracoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ConfiguracoesController extends Controller
{
    //


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $data = Input::all();

        foreach ($data as $key => $value) {
            if ($key == '_token')
                continue;

            Configuracoes::where('chave',$key)->update([
                'valor' => $value
            ]);
        }

        return redirect()->back()->with('message','Salvo com sucesso.');
    }
}
