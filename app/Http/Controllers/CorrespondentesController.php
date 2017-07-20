<?php

namespace App\Http\Controllers;

use App\Comarca;
use App\Correspondente;
use App\Servico;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Nayjest\Grids\Components\ColumnHeadersRow;
use Nayjest\Grids\Components\ColumnsHider;
use Nayjest\Grids\Components\FiltersRow;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\Pager;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\TFoot;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\Components\TotalsRow;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use Nayjest\Grids\IdFieldConfig;
use Nayjest\Grids\SelectFilterConfig;

class CorrespondentesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        # Some params may be predefined, other can be controlled using grid components
        $query = (new Correspondente())
            ->with('servicos')
            ->with('user')
            ->has('user')
            ->orderBy('correspondentes.created_at','DESC')
            ->newQuery();

        # Instantiate & Configure Grid
        $grid = new Grid(
            (new GridConfig())
                # Grids name used as html id, caching key, filtering GET params prefix, etc
                # If not specified, unique value based on file name & line of code will be generated
                ->setName('correspondentes')
                # See all supported data providers in sources
                ->setDataProvider(new EloquentDataProvider($query))
                # Setup caching, value in minutes, turned off in debug mode
                //->setCachingTime(0)
                # Setup table columns
                ->setColumns([
                    # simple results numbering, not related to table PK or any obtained data
                    (new FieldConfig)
                        ->setName('actions')
                        ->setLabel('Ações')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                            $button1 = $button2 = $button3 = '';

                            $button1 = ' <div style="float: left">'.
                                '<span data-ref="'.route('correspondentes.comarcas', ['id' => $row->getSrc()->id])
                                .'" class="btn btn-sm btn-success btn-transparent btn-rounded edit-comarcas">'
                                .' <i class="fa fa-institution"></i></span></div> ';

                            $button2 = ' <div style="float: left">'.
                                '<span data-ref="'.route('correspondentes.edit', ['id' => $row->getSrc()->id])
                                .'" class="btn btn-sm btn-info btn-transparent btn-rounded edit-entity">'
                                .' <i class="fa fa-pencil"></i></span></div> ';

                            // Em negociacao?
                            if ($row->getSrc()->status_id == '6') {
                                $button3 = ' <div style="float: left">'.
                                    '<button type="button" class="btn btn-danger btn-rounded" data-container="body"
                                    data-toggle="tooltip" data-placement="bottom"
                                     data-original-title="Você tem ações importantes para executar nesta diligência!"><i class="fa fa-warning"></i></button></div> ';
                            }

                            return '<div style="min-width: 120px">' . $button1 . $button2 . $button3 . '</div>';
                        })
                    ,
                    new IdFieldConfig(),
                    (new FieldConfig)
                        ->setName('ativo')
                        ->setLabel('Ativo')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                            return (!$val || $val == '0')? 'Não' : 'Sim';
                        })
                    ,
                    (new FieldConfig())
                        ->setName('nome')
                        ->addFilter(
                            (new FilterConfig())
                                ->setName('nome')
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )
                        ->setSortable(true)
                    ,
                    (new FieldConfig)
                        ->setName('user')
                        ->setLabel('Email')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                            if (!$val->email)
                                return '';

                            return $val->email;
                        })
                    ,
                    (new FieldConfig)
                        ->setName('comarcas')
                        ->setLabel('Comarca')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {
                            if (!$val)
                                return '';

                            $comarcas = '';
                            foreach ($val as $comarca) {
                                $comarcas .= $comarca->comarca . '<br>';
                            }
                            return $comarcas;
                        })
                    ,
                    (new FieldConfig)
                        ->setName('rating')
                        ->setLabel('Rating')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                            if (!$val)
                                return '';

                            return getRatingStars($val);
                        })
                    ,
                ])
                # Setup additional grid components
                ->setComponents([
                    # Renders table header (table>thead)
                    (new THead())
                        # Setup inherited components
                        ->setComponents([
                            (new ColumnHeadersRow())
                                ->setAttributes([
                                    'class' => 'info'
                                ]),
                            # Add this if you have filters for automatic placing to this row
                            new FiltersRow(),
                            # Row with additional controls
                            (new OneCellRow())
                                ->setComponents([
                                    # Control for specifying quantity of records displayed on page
                                    (new RecordsPerPage())
                                        ->setVariants([
                                            50,
                                            100,
                                            1000
                                        ])
                                    ,
                                    # Control to show/hide rows in table
                                    (new ColumnsHider())
                                        ->setHiddenByDefault([
                                            'activated_at',
                                            'updated_at',
                                            'registration_ip',
                                        ])
                                    ,
                                    # Submit button for filters.
                                    # Place it anywhere in the grid (grid is rendered inside form by default).
                                    (new HtmlTag)
                                        ->setContent('<span class="glyphicon glyphicon-refresh" id="filter-btn"></span> Filter ')
                                        ->setTagName('button')
                                        ->setAttributes([
                                            'class' => 'btn btn-success btn-sm btn-grid'
                                        ]),
                                ])
                                # Components may have some placeholders for rendering children there.
                                ->setRenderSection(THead::SECTION_BEGIN)
                        ])
                    ,
                    # Renders table footer (table>tfoot)
                    (new TFoot())
                        ->addComponent(
                        # TotalsRow component calculates totals on current page
                        # (max, min, sum, average value, etc)
                        # and renders results as table row.
                        # By default there is a sum.
                            new TotalsRow([
                                'diligencias',
                            ])
                        )
                ])
        );

        return view('correspondentes.index',compact('grid'));
    }

    /**
     * Porta de entrada do correspondente na plataforma com um token
     *
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function entrar($token)
    {
        $user = User::where('token', $token)->first();

        if (!$user || $user->count() <= 0)
            abort(403, 'Erro em sua conta!');

        Auth::login($user,true);

        //return view('correspondentes.entrar',compact('user'));
        return redirect()->action('PagesController@dashboard_correspondente');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estados = Comarca::getEstadosList()->prepend('Selecione uma opção', '0');

        $servicos = Servico::get();

        $tipos_conta = [
            '0' => 'Selecione uma opção',
            'PF' => 'Pessoa Física',
            'PJ' => 'Pessoa Jurídica'
        ];

        return view('correspondentes.create',compact('servicos','estados', 'tipos_conta'));
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
        $this->validate($request, [
            //'comarca_id' => 'required|not_in:0',
            'nome' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4',
            //'bank' => 'int',
        ],[
            'comarca_id.required' => 'Você precisa selecionar uma Comarca.',
            'comarca_id.not_in' => 'Você precisa selecionar uma Comarca.',
            'nome.required' => 'Você precisa digitar um Nome.',
            'email.required' => 'Você precisa digitar um Email.',
            'bank.int' => 'Banco deve ser o número do banco',
            'cpf.int' => 'CPF deve ser composto apenas por números',
            'cnpj.int' => 'CNPJ deve ser composto apenas por números'
        ]);

        $data = Input::all();

        $correspondente = Correspondente::create([
            'nome' => $data['nome']
        ]);
/*
        // Salvou
        if ($correspondente) {

            // Salva os serviços
            foreach ($data['servico'] as $key => $servico) {
                if (!$servico['valor'] || empty($servico['valor']))
                    continue;

                $correspondente->servicos()->attach($key, ['valor' => $servico['valor']]);
            }

            // Salva comarca
            if (!empty($data['comarca_id'])) {
                $correspondente->comarcas()->attach($data['comarca_id']);
            }
        }*/

        // Cria o usuario
        $user = User::create([
            'nome' => $data['nome'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'endereco' => $data['endereco'],
            'level' => '1',
            'correspondente_id' => $correspondente->id,
            'cpf' => $data['cpf']
        ]);

        if ($user)
            $message = 'Sucesso';
        else
            $message = 'Fail!';

        return redirect()->action('CorrespondentesController@index')
                ->with('message',$message);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function comarcasStore(Request $request)
    {
        //
        $this->validate($request, [
            'comarca_id' => 'required|not_in:0',
            'correspondente_id' => 'required|not_in:0'
        ],[
            'comarca_id.required' => 'Você precisa selecionar uma Comarca.',
            'correspondente_id.required' => 'Nenhum correspondente vinculado.',
        ]);

        $data = Input::all();

        // Verifica se o correspondente já tem essa comarca
        $correspondente = Correspondente::where('id', $data['correspondente_id'])->first();

        $existe = $correspondente->comarcas()->where('comarca_id',$data['comarca_id'])
                ->where('correspondente_id',$data['correspondente_id'])->first();

        // Já existe esta comarca para o correspondente
        if ($existe && !empty($existe)) {
            $rules = ['servico' => 'required'];
            $messages = ['servico' => 'required'];

            $validation = Validator::make($data, $rules, $messages);
            $validation->getMessageBag()->add('comarca', 'O correspondente já tem esta comarca. Procure na lista para editar.');

            return redirect()->back()->withErrors($validation)->withInput();
        }

        // Servico?
        if (!$this->validateServicos($data['servico'])) {

            $rules = ['servico' => 'required'];
            $messages = ['servico' => 'required'];

            $validation = Validator::make($data, $rules, $messages);
            $validation->getMessageBag()->add('servico', 'Ao menos um serviço é necessário');

            return redirect()->back()->withErrors($validation)->withInput();
        }

        // Salvou
        if ($correspondente) {

            // Salva os serviços
            foreach ($data['servico'] as $key => $servico) {
                if (!$servico['valor'] || empty($servico['valor']))
                    continue;

                // Salva servico - comarca - corresp
                $correspondente->servicos()->attach($key, ['valor' => $servico['valor'],'comarca_id' => $data['comarca_id']]);
            }

            // Salva comarca
            if (!empty($data['comarca_id'])) {
                $correspondente->comarcas()->attach($data['comarca_id']);
            }
        }

        return redirect()->action('CorrespondentesController@index')
            ->with('message','Sucesso');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function comarcasUpdate(Request $request)
    {
        //
        $this->validate($request, [
            'comarca_id' => 'required|not_in:0',
            'correspondente_id' => 'required|not_in:0'
        ],[
            'comarca_id.required' => 'Você precisa selecionar uma Comarca.',
            'correspondente_id.required' => 'Nenhum correspondente vinculado.',
        ]);

        $data = Input::all();

        // Verifica se o correspondente já tem essa comarca
        $correspondente = Correspondente::where('id', $data['correspondente_id'])->first();

        // Salva
        if ($correspondente) {

            // desativa todos os servicos desta comarca
            $correspondente->servicos()->where('comarca_id',$data['comarca_id'])->detach();

            // Salva o servico
            foreach ($data['servico'] as $key => $servico) {
                if (!$servico['valor'] || empty($servico['valor']))
                    continue;

                // Salva servico - comarca - corresp
                $correspondente->servicos()->attach($key, ['valor' => $servico['valor'],'comarca_id' => $data['comarca_id']]);
            }
        }

        return redirect()->back()
            ->with('message','Sucesso');
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
        $correspondente = Correspondente::where('id',$id)
            ->with('user')
            ->with('comarcas')
            ->with('servicos')
            ->first();

        $estados = Comarca::getEstadosList()->prepend('Selecione uma opção', '0');

        $servicos = Servico::get();

        $tipos_conta = [
            '0' => 'Selecione uma opção',
            'PF' => 'Pessoa Física',
            'PJ' => 'Pessoa Jurídica'
        ];

        $ativo_options = Correspondente::$ativo_options;

        return view('correspondentes.edit',compact('correspondente','servicos','estados', 'tipos_conta', 'ativo_options'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function comarcas($id)
    {
        //
        $correspondente = Correspondente::where('correspondentes.id',$id)
            ->with('user')
            ->with('servicos')
            ->first();

        //dd($correspondente->servicos()->where('comarca_id','5602')->first());
        $estados = Comarca::getEstadosList()->prepend('Selecione uma opção', '0');

        $servicos = Servico::get();

        $tipos_conta = [
            '0' => 'Selecione uma opção',
            'PF' => 'Pessoa Física',
            'PJ' => 'Pessoa Jurídica'
        ];

        return view('correspondentes.comarcas',compact('correspondente','servicos','estados', 'tipos_conta'));
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
        $this->validate($request, [
            'nome' => 'required|min:3',
            'email' => 'required|email'
        ],[
            'comarca_id.required' => 'Você precisa selecionar uma Comarca.',
            'comarca_id.not_in' => 'Você precisa selecionar uma Comarca.',
            'bank.int' => 'Banco deve ser o número do banco',
            'cpf.int' => 'CPF deve ser composto apenas por números',
            'cnpj.int' => 'CNPJ deve ser composto apenas por números'
        ]);

        $data = Input::all();

        $save = Correspondente::where('id',$id)->update([
            'nome' => $data['nome'],
            'bank' => $data['bank'],
            'ag' => $data['ag'],
            'conta' => $data['conta'],
            'cnpj' => $data['cnpj'],
            'ativo' => $data['ativo'],
        ]);

        $correspondente = Correspondente::where('id',$id)->first();
/*
        if ($correspondente) {

            $correspondente->servicos()->detach();

            foreach ($data['servico'] as $key => $servico) {
                if (!$servico['valor'] || empty($servico['valor']))
                    continue;

                $correspondente->servicos()->attach($key, ['valor' => $servico['valor']]);
            }

            if (!empty($data['comarca_id'])) {
                $correspondente->comarcas()->detach();
                $correspondente->comarcas()->attach($data['comarca_id']);
            }
        }*/

        if ($data['password'] && !empty($data['password'])) {
            $user = User::where('correspondente_id',$id)->update([
                'nome' => $data['nome'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'],
                'endereco' => $data['endereco'],
                'level' => '1',
                'correspondente_id' => $correspondente->id
            ]);
        }
        else {
            $user = User::where('correspondente_id',$id)->update([
                'nome' => $data['nome'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'endereco' => $data['endereco'],
                'level' => '1',
                'correspondente_id' => $correspondente->id
            ]);
        }


        if ($user)
            $message = 'Sucesso';
        else
            $message = 'Fail!';

        return redirect()->action('CorrespondentesController@index')
            ->with('message',$message);
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

    public function get()
    {

        
    }

    public function validateServicos($servicos)
    {
        $vazio = true;

        foreach ($servicos as $servico) {
            if (!array_filter($servico)) {
                // all values are empty (where "empty" means == false)
            }
            else
                $vazio = false;
        }

        return !$vazio;
    }
}
