<?php

namespace App\Http\Controllers;

use App\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ServicosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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

        if (!empty($data['Preposto'])) {
            Servico::where('servico','Preposto')->update([
                'ideal' => $data['Preposto']['ideal'],
                'max' => $data['Preposto']['max'],
            ]);
        }

        if (!empty($data['Advogado'])) {
            Servico::where('servico','Advogado')->update([
                'ideal' => $data['Advogado']['ideal'],
                'max' => $data['Advogado']['max'],
            ]);
        }

        if (!empty($data['Advogado_+_Preposto'])) {
            Servico::where('id','3')->update([
                'ideal' => $data['Advogado_+_Preposto']['ideal'],
                'max' => $data['Advogado_+_Preposto']['max'],
            ]);
        }

        if (!empty($data['Diligência'])) {
            Servico::where('id','4')->update([
                'ideal' => $data['Diligência']['ideal'],
                'max' => $data['Diligência']['max'],
            ]);
        }


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
