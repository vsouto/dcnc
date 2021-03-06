<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
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

class AdvogadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //
        # Some params may be predefined, other can be controlled using grid components
        $query = (new User())
            ->whereNotNull('cliente_id')
            ->with('cliente')
            ->newQuery();

        # Instantiate & Configure Grid
        $grid = new Grid(
            (new GridConfig())
                # Grids name used as html id, caching key, filtering GET params prefix, etc
                # If not specified, unique value based on file name & line of code will be generated
                ->setName('Advogados')
                # See all supported data providers in sources
                ->setDataProvider(new EloquentDataProvider($query))
                # Setup caching, value in minutes, turned off in debug mode
                //->setCachingTime(5)
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
                                '<span data-ref="'.route('advogados.edit', ['id' => $row->getSrc()->id])
                                .'" class="btn btn-sm btn-info btn-transparent btn-rounded edit-entity">'
                                .' <i class="fa fa-pencil"></i></span></div> ';

                            return '<div style="min-width: 120px">' . $button1 .  '</div>';
                        })
                    ,
                    new IdFieldConfig(),
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
                        ->setName('cliente')
                        ->setLabel('Cliente')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {
                            if (!$val)
                                return '';

                            return '<span class="edit-gss" data-call-id="'.$row->getSrc()->id.'">'.$val->nome .'</span>';
                        })
                    ,
                    (new FieldConfig)
                        ->setName('email')
                        ->setLabel('Email')
                        ->setSortable(true)
                    ,
                    (new FieldConfig)
                        ->setName('endereco')
                        ->setLabel('Endereço')
                        ->setSortable(true)
                    ,
                    (new FieldConfig)
                        ->setName('phone')
                        ->setLabel('Telefone')
                        ->setSortable(true)
                    ,
                    (new FieldConfig)
                        ->setName('ativo')
                        ->setLabel('Ativo')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                            if ($val)
                                $span = '<span class="text text-success">Sim</span>';
                            else
                                $span = '<span class="text text-danger">Não</span>';

                            return $span;

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

        return view('advogados.index',compact('grid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // Clients
        $clientes = Cliente::pluck('nome','id')->prepend('-- Please Select-- ',0);

        return view('advogados.create',compact('clientes'));
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
            'nome' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'senha' => 'required|min:4',
        ]);

        $data = Input::all();

        $user = User::create([
            'nome' => $data['nome'],
            'email' => $data['email'],
            'password' => Hash::make($data['senha']),
            'phone' => $data['phone'],
            'endereco' => $data['endereco'],
            'level' => '2',
            'cliente_id' => $data['cliente_id']
        ]);

        if ($user)
            $message = 'Sucesso';
        else
            $message = 'Fail!';

        return redirect()->action('AdvogadosController@index')
            ->with('message',$message);
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
        $advogado = User::where('id',$id)->first();

        // Clients
        $clientes = Cliente::pluck('nome','id')->prepend('-- Please Select-- ',0);

        return view('advogados.edit', compact('advogado','clientes'));
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
            'email' => 'required|email',
        ]);

        $data = Input::only('nome','email','senha','phone','endereco','cliente_id','ativo');

        $ativo = isset($data['ativo']) && $data['ativo'] == '1'? '1' : '0';

        if (isset($data['senha']) && !empty($data['senha'])) {

            $user = User::where('id',$id)->update([
                'nome' => $data['nome'],
                'email' => $data['email'],
                'password' => Hash::make($data['senha']),
                'phone' => $data['phone'],
                'endereco' => $data['endereco'],
                'cliente_id' => $data['cliente_id'],
                'ativo' => $ativo
            ]);
        }
        else {
            $user = User::where('id',$id)->update([
                'nome' => $data['nome'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'endereco' => $data['endereco'],
                'cliente_id' => $data['cliente_id'],
                'ativo' => $ativo,
            ]);
        }


        if ($user)
            $message = 'Sucesso';
        else
            $message = 'Fail!';

        return redirect()->action('AdvogadosController@index')
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
}
