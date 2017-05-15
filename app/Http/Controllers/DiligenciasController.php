<?php

namespace App\Http\Controllers;

use App\Advogado;
use App\Comarca;
use App\Correspondente;
use App\Diligencia;
use App\File;
use App\Status;
use App\Tipo;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Nayjest\Grids\Components\Base\RenderableRegistry;
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

class DiligenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        # Some params may be predefined, other can be controlled using grid components
        $query = (new Diligencia())
            ->with('servicos')
            ->with('correspondente')
            ->with('advogado')
            ->newQuery();

        # Instantiate & Configure Grid
        $grid = new Grid(
            (new GridConfig())
                # Grids name used as html id, caching key, filtering GET params prefix, etc
                # If not specified, unique value based on file name & line of code will be generated
                ->setName('Diligencias')
                # See all supported data providers in sources
                ->setDataProvider(new EloquentDataProvider($query))
                # Setup caching, value in minutes, turned off in debug mode
                //->setCachingTime(5)
                # Setup table columns
                ->setColumns([
                    # simple results numbering, not related to table PK or any obtained data
                    (new FieldConfig())
                        ->setName('id')
                        ->setLabel('ID')
                        ->addFilter(
                            (new FilterConfig())
                                ->setName('id')
                        )
                        ->setSortable(true)
                    ,
                    (new FieldConfig())
                        ->setName('titulo')
                        ->setLabel('Título')
                        ->addFilter(
                            (new FilterConfig())
                                ->setName('titulo')
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )
                        ->setSortable(true)
                    ,
                    (new FieldConfig)
                        ->setName('status_id')
                        ->setLabel('Status')
                        ->addFilter(
                            (new \Nayjest\Grids\SelectFilterConfig())
                                ->setMultipleMode(true)
                                ->setOptions(\App\Status::getList())
                        )
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {
                            if (!$val)
                                return '';

                            $status = Status::where('id',$val)->first();

                            return "<span class='badge {$status->class} edit-status'>{$status->status}</span>";
                        })
                        ->setSortable(true)
                    ,
                    (new FieldConfig)
                        ->setName('urgencia')
                        ->setLabel('Urgência')
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {
                            if (!$val)
                                return '';

                            return "<span class='label label-info'>Normal</span>";
                        })
                        ->setSortable(true)
                    ,
                    (new FieldConfig)
                        ->setName('tipo')
                        ->setLabel('Tipo')
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {
                            if (!$val)
                                return '';

                            return '<span class="edit-gss" data-call-id="'.$row->getSrc()->id.'">'.$val->tipo .'</span>';
                        })
                        ->setSortable(true)
                    ,
                    (new FieldConfig)
                        ->setName('descricao')
                        ->setLabel('Descrição')
                        ->setSortable(true)
                    ,
                    (new FieldConfig)
                        ->setName('comarca')
                        ->setLabel('Comarca')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {
                            if (!$row->getSrc()->correspondente_id)
                                return '';

                            $correspondente = Correspondente::where('id',$row->getSrc()->correspondente_id)
                                    ->with('comarca')->first();

                            if (!$correspondente || !$correspondente->comarca)
                                return '';

                            return '<span class="edit-gss" data-call-id="'.$row->getSrc()->id.'">'.
                                $correspondente->comarca->comarca .'</span>';
                        })
                    ,
                    (new FieldConfig)
                        ->setName('correspondente_id')
                        ->setLabel('Correspondente')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {
                            if (!$val)
                                return '';

                            $correspondente = Correspondente::where('id',$val)->first();

                            if (!$correspondente)
                                return '';

                            return '<span class="edit-gss" data-call-id="'.$row->getSrc()->id.'">'.$correspondente->nome .'</span>';
                        })
                    ,
                    (new FieldConfig)
                        ->setName('servico')
                        ->setLabel('Serviço')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                            // Any servico?
                            if (!$row->getSrc()->servicos || empty($row->getSrc()->servicos) || $row->getSrc()->servicos->count() <= 0)
                                return '';

                            $string = '';

                            foreach ($row->getSrc()->servicos as $servico) {
                                $string .= $servico->servico . '<br>';
                            }

                            return '<span class="edit-gss" data-call-id="'.$row->getSrc()->id.'">'.$string.'</span>';
                        })
                    ,
                    (new FieldConfig)
                        ->setName('valor')
                        ->setLabel('Valor')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                            // Any serviços?
                            if (!$row->getSrc()->servicos)
                                return '';

                            $string = '';

                            // Apenas tem valor se tiver correspondente selecionado
                            if (!$row->getSrc()->correspondente)
                                return '';

                            $servicos = $row->getSrc()->correspondente->servicos()->get();
                            $valor = 0;

                            // Pra cada serviço, pega o valor do correspondente
                            foreach ($servicos as $servico) {
                                $valor += $servico->pivot->valor;
                            }

                            return '<span class="edit-gss" data-call-id="'.$row->getSrc()->id.'">R$ '.$valor.'</span>';
                        })
                    ,
                    (new FieldConfig)
                        ->setName('cliente')
                        ->setLabel('Cliente')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                            if (!$row->getSrc()->advogado || !$row->getSrc()->advogado->cliente)
                                return '';

                            return '<span class="edit-gss" data-call-id="'.$row->getSrc()->id.'">'.$row->getSrc()->advogado->cliente->nome .'</span>';
                        })
                    ,
                    (new FieldConfig)
                        ->setName('advogado')
                        ->setLabel('Advogado')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                            if (!$row->getSrc()->advogado)
                                return '';

                            return '<span class="edit-gss" data-call-id="'.$row->getSrc()->id.'">'.$row->getSrc()->advogado->nome .'</span>';
                        })
                    ,
                    (new FieldConfig)
                        ->setName('actions')
                        ->setLabel('Ações')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                            $button1 = $button2 = $button3 = '';

                            $button1 = '<div style="float: left">'.
                                '<span data-ref="'.route('diligencias.show', ['id' => $row->getSrc()->id]).'" class="btn btn-sm btn-info btn-rounded view-diligencia">'.
                                ' <i class="fa fa-search"></i></span></div> ';

                            $button2 = ' <div style="float: left">'.
                                '<span data-ref="'.route('diligencias.edit', ['id' => $row->getSrc()->id]).'" class="btn btn-sm btn-info btn-transparent btn-rounded edit-diligencia">'.
                                ' <i class="fa fa-pencil"></i></span></div> ';

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

        $statuses = Status::get();

        return view('diligencias.index',compact('grid','statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $statuses = Status::pluck('status','id');

        $advogados = User::getAdvogadosList();

        $users = User::pluck('nome','id');

        $tipos = Tipo::getList();

        return view('diligencias.create',compact('users', 'statuses','tipos','advogados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => 'required|min:3|max:65',
            'descricao' => 'required|min:3',
            'num_processo' => 'required',
            'tipo_id' => 'required',
            'reu' => 'required',
            'advogado_id' => 'required', // cliente
            'orgao' => 'required',
            'prazo' => 'required|date',
            'solicitante' => 'required',
            'orientacoes' => 'required|min:5',
        ],[
            'titulo.required' => 'Você precisa digitar um Título.',
            'descricao.required' => 'Você precisa digitar uma Descrição.',
            'num_processo.required' => 'Você precisa digitar um Número de Processo válido.',
            'tipo_id.required' => 'Você precisa selecionar um Tipo.',
            'reu.required' => 'Você precisa digitar um Réu.',
            'orgao.required' => 'Você precisa digitar um Órgão.',
            'prazo.required' => 'Você precisa digitar um Prazo.',
            'solicitante.required' => 'Você precisa digitar um Solicitante.',
            'orientacoes.required' => 'Você precisa digitar um mínimo de Orientações.',
            'advogado_id.required' => 'Você precisa selecionar um advogado cliente.',
        ]);

        $data = Input::only(
            'titulo',
            'descricao',
            'num_integracao',
            'num_processo',
            'prazo',
            'tipo_id',
            'advogado_id',
            'solicitante',
            'reu',
            'orgao',
            'local_orgao',
            'vara',
            'orientacoes'
        );

        // Set status
        $data['status_id'] = Status::where('slug','sondagem')->first()->id;

        // Treat File Uploads
        if ($request->hasFile('files')) {

            $files = Input::file('files');
            $files_ids = [];

            foreach ($files as $file) {

                $filename = $file->store('files');

                $new_file = File::create([
                    'titulo' => $filename,
                    'descricao' => $filename,
                    'filename' => $filename,
                    'user_id' => Auth::user()->id
                ]);

                // TODO attach file do diligencia
                $files_ids[] = $new_file->id;
            }
        }

        // Prazo to pattern
        if (!empty($data['prazo'])) {
            $data['prazo'] = Carbon::createFromFormat('d/m/Y',$data['prazo']);
        }

        // Create
        $save = Diligencia::create($data);

        if ($save) {

            if (!empty($files_ids)) {
                // Attach files to this Diligencia
                foreach ($files_ids as $file) {
                    $save->files()->attach($file);
                }
            }

            return redirect()->route('diligencias.index')->with('message', 'Nova Diligência criada com sucesso.');
        }
        else {
            return redirect()->back()->with('message','Algo aconteceu de errado.');
        }


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
        $diligencia = Diligencia::where('id',$id)
            ->with('files')
            ->with('servicos')
            ->with('correspondente')
            ->with('advogado','advogado.cliente')
            ->first();

        $correspondentes_recomendados = [];

        // Em negociacao?
        if ($diligencia->status_id == 6) {
            // Todo automatizar definição da comarca na diligencia
            $correspondentes_recomendados = Correspondente::where('comarca_id',1)
                ->with('servicos')
                /*->with(array('servicos' => function($query) use ($diligencia)
                {
                    $query->whereIn('servicos.id', $diligencia->servicos);
                }))*/
                ->with('user')
                ->take(5)
                ->get();
        }
        return view('diligencias.show',compact('diligencia', 'correspondentes_recomendados'));
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
        $diligencia = Diligencia::where('id',$id)
            ->with('files')
            ->with('servicos')
            ->with('correspondente')
            ->with('advogado','advogado.cliente')
            ->first();

        return view('diligencias.edit', compact('diligencia'));
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

    /**
     * Correspondente aceita uma diligencia
     *
     * @param $id
     */
    public function aceitar($id)
    {
        if (!$id)
            abort(403,'wat');

        $diligencia = Diligencia::where('id',$id)->update([
            'status_id' => '3'
        ]);

        return redirect()->back()->with('message', 'Diligência aceita com sucesso.');
    }

    /**
     * Correspondente faz checkin em uma diligencia
     *
     * @param $id
     */
    public function checkin($id)
    {
        if (!$id)
            abort(403,'wat');

        $diligencia = Diligencia::where('id',$id)->update([
            'status_id' => '4'
        ]);

        return redirect()->back()->with('message', 'Checkin efetuado com sucesso.');
    }

    /**
     * Correspondente conclui uma diligencia
     *
     * @param $id
     */
    public function concluir($id)
    {
        if (!$id)
            abort(403,'wat');

        $diligencia = Diligencia::where('id',$id)->update([
            'status_id' => '8'
        ]);

        return redirect()->back()->with('message', 'Diligência concluída com sucesso. Aguarde decisão da revisão.');
    }

    /**
     * Revisar e aprovar uma diligencia
     *
     * @param $id
     */
    public function aprovar($id)
    {
        if (!$id)
            abort(403,'wat');

        $diligencia = Diligencia::where('id',$id)->update([
            'status_id' => '10'
        ]);

        return redirect()->back()->with('message', 'Diligência aprovada com sucesso. O financeiro será acionado como Pagamento Autorizado.');
    }

    /**
     * Revisar e devolver uma diligencia
     *
     * @param $id
     */
    public function devolver($id)
    {
        if (!$id)
            abort(403,'wat');

        $diligencia = Diligencia::where('id',$id)->update([
            'status_id' => '9'
        ]);

        return redirect()->back()->with('message', 'Diligência devolvida. O correspondente será acionado para revisar o trabalho.');
    }

}
