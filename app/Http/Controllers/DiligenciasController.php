<?php

namespace App\Http\Controllers;

use App\Advogado;
use App\Cliente;
use App\Comarca;
use App\Correspondente;
use App\Diligencia;
use App\Email;
use App\File;
use App\Pagamento;
use App\Servico;
use App\Sondagem;
use App\Status;
use App\Tipo;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Readers\Html;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\ColumnHeadersRow;
use Nayjest\Grids\Components\ColumnsHider;
use Nayjest\Grids\Components\Filters\DateRangePicker;
use Nayjest\Grids\Components\FiltersRow;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\Pager;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\RenderFunc;
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
            ->orderBy('created_at','DESC')
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

                    (new FieldConfig())
                        ->setName('prazo')
                        ->setLabel('Prazo')
                        ->setSortable(true)
                        ->setCallback(function (Carbon $val, \Nayjest\Grids\EloquentDataRow $row) {
                            return $val->diffForHumans();
                        })
                    ,
                    (new FieldConfig)
                        ->setName('urgencia')
                        ->setLabel('Urgência')
                        ->addFilter(
                            (new \Nayjest\Grids\SelectFilterConfig())
                                ->setMultipleMode(true)
                                ->setOptions($this->getUrgenciaList())
                        )
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                            if (!$val)
                                return '';

                            return getUrgenciaClass($val);
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
                        ->setCallback(function ($val) {
                            if (!$val)
                                return '';

                            return $val->comarca;
                        })
                    ,
                    (new FieldConfig)
                        ->setName('correspondente_id')
                        ->setLabel('Correspondente')
                        ->setSortable(true)
                        ->addFilter(
                            (new \Nayjest\Grids\SelectFilterConfig())
                                ->setSubmittedOnChange(true)
                                ->setOptions(Correspondente::pluck('nome','id')->toArray())
                        )
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

                            $servico = $row->getSrc()->servicos()->first();
                            $servico_id = $servico['id'];
                            $correspondente_id = $row->getSrc()->correspondente->id;


                            $get = DB::select("SELECT valor from correspondente_servico WHERE servico_id = '$servico_id'
                              AND correspondente_id = '$correspondente_id'");

                            if ($get && isset($get[0]))
                                return '<span class="edit-gss" data-call-id="'.$row->getSrc()->id.'">R$ '
                                    .$get[0]->valor.'</span>';
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
                            (new FiltersRow)
                                ->addComponents([
                                    (new DateRangePicker())
                                        ->setName('diligencias.prazo')
                                        ->setRenderSection(RenderableRegistry::SECTION_BEFORE)
                                        ->setDefaultValue(['', date('Y-m-d')])
                                        ->setJsOptions($this->getDates())
                                        ->setLabel('Período:'),
                                ]),
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
                                    ,/*
                                    # Control to show/hide rows in table
                                    (new ColumnsHider())
                                        ->setHiddenByDefault([
                                            'activated_at',
                                            'updated_at',
                                            'registration_ip',
                                        ])
                                    ,*/
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
        $advogados = User::getAdvogadosList();

        $estados = Comarca::getEstadosList()->prepend('Selecione uma opção', '0');

        //$comarcas = Comarca::pluck('comarca','id')->prepend('Selecione uma opção', '0');

        $servicos = Servico::get();

        return view('diligencias.create',compact('tipos','advogados','servicos','estados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $today = Carbon::today();

        $this->validate($request, [
            'comarca_id' => 'required|not_in:0',
            'titulo' => 'required|min:3|max:65',
            'descricao' => 'required|min:3',
            'num_processo' => 'required',
            'reu' => 'required',
            'advogado_id' => 'required|not_in:0', // cliente
            'orgao' => 'required',
            'prazo' => 'required|date_format:"d/m/Y H:i"|after:' . $today,
            'solicitante' => 'required',
            'orientacoes' => 'required|min:5',
            'servico_id' => 'required',
            'vara' => 'required',
            'autor' => 'required',
        ],[
            'comarca_id.required' => 'Você precisa selecionar uma Comarca.',
            'comarca_id.not_in' => 'Você precisa selecionar uma Comarca.',
            'titulo.required' => 'Você precisa digitar um Título.',
            'descricao.required' => 'Você precisa digitar uma Descrição.',
            'num_processo.required' => 'Você precisa digitar um Número de Processo válido.',
            'reu.required' => 'Você precisa digitar um Réu.',
            'orgao.required' => 'Você precisa digitar um Órgão.',
            'prazo.required' => 'Você precisa digitar um Prazo.',
            'prazo.after' => 'O Prazo precisa ser a partir da data de hoje.',
            'solicitante.required' => 'Você precisa digitar um Solicitante.',
            'orientacoes.required' => 'Você precisa digitar um mínimo de Orientações.',
            'advogado_id.required' => 'Você precisa selecionar um Advogado cliente.',
            'advogado_id.not_in' => 'Você precisa selecionar um Advogado cliente.',
            'servico_id.required' => 'Você precisa selecionar ao menos um Serviço.',
            'vara.required' => 'Você precisa preencher a Vara.',
            'autor.required' => 'Você precisa digitar o autor.',
        ]);

        $data = Input::only(
            'comarca_id',
            'titulo',
            'descricao',
            'num_integracao',
            'num_processo',
            'prazo',
            'advogado_id',
            'solicitante',
            'reu',
            'orgao',
            'local_orgao',
            'vara',
            'orientacoes',
            'servico_id',
            'autor'
        );

        // Prazo to pattern
        if (!empty($data['prazo'])) {
            $data['prazo'] = Carbon::createFromFormat('d/m/Y H:i',$data['prazo']);
        }

        // Select the best Correspondente for this
        $correspondente = Correspondente::getBestCorrespondenteForDiligencia($data['comarca_id'], $data['servico_id']);

        // Se não encontrou correspondente
        if (!$correspondente) {

            // A diligencia entrará como Em Negociação
            $data['status_id'] = Status::where('slug','em-negociacao')->first()->id;
        }
        else {
            // Set status Aguardando Confirmação
            $data['status_id'] = Status::where('slug','aguardando-confirmacao')->first()->id;

            $data['correspondente_id'] = $correspondente[0]->correspondente_id;
        }

        // Salva o servico
        if (!empty($data['servico_id'])) {
            $servico_id = $data['servico_id'];
            unset($data['servico_id']);
        }

        // Define a sondagem do correspondente como este momento
        $data['sondagem'] = Carbon::now();

        // Create
        $save = Diligencia::create($data);

        if ($save) {

            // Treat File Uploads
            if ($request->hasFile('files')) {

                $files = Input::file('files');
                $files_ids = [];

                foreach ($files as $file) {

                    //$filename = $file->store('files');
                    $name = Storage::disk('uploads')->put($save->id, $file, 'public');

                    $new_file = File::create([
                        'titulo' => 'Anexo em D-' . $save->id,
                        'descricao' => 'Anexo em Diligência ' . $save->id,
                        'filename' => $name,
                        'user_id' => Auth::user()->id
                    ]);

                    $files_ids[] = $new_file->id;
                }
            }

            // Attach files
            if (!empty($files_ids)) {
                // Attach files to this Diligencia
                foreach ($files_ids as $file) {
                    $save->files()->attach($file);
                }
            }

            // Attach servicos
            if (!empty($servico_id)) {

                $save->servicos()->attach($servico_id);
            }

            // Dispara email cliente
            Email::setupAndFire('A_1', ['type' => 'advogado_id', 'id' => $data['advogado_id']], $save);

            if (isset($data['correspondente_id']) && !empty($data['correspondente_id'])) {
                // Dispara email correspondente
                Email::setupAndFire('A_2', ['type' => 'correspondente_id', 'id' => $data['correspondente_id']], $save);
            }

            // Se foi cadastrado pelo cliente
            if (Auth::user()->level == 2)
                return redirect()->route('dashboard_cliente')->with('message', 'Nova Diligência criada com sucesso.');
            else
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
            ->firstOrFail();

        // Se é um correspondente, registra visita
        if (Auth::user()->level == '1') {
            $diligencia->update([
                'visited_by_correspondente' => '1'
            ]);
        }
/*
        foreach($diligencia->files as $file) {

            $filezera = Storage::disk('uploads')->url($file->filename);

            //var_dump($filezera);

            var_dump(public_path() . '/uploads/'  . $file->filename);
        }
exit;*/
        $correspondentes_recomendados = [];

        // Em negociacao?
        if ($diligencia->status_id == 6) {

            // No servicos?
            if ($diligencia->servicos()->count() <= 0) {
                $correspondentes_recomendados = false;
            }
            else {
                $comarca_id = $diligencia->comarca_id;
                $servico_id = $diligencia->servicos()->first()->id;

                $correspondentes_recomendados = Correspondente::getRecomendados($servico_id,$comarca_id);
            }
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
            ->with('comarca')
            ->with('advogado','advogado.cliente')
            ->first();

        $advogados = User::getAdvogadosList();

        $estados = Comarca::getEstadosList()->prepend('Selecione uma opção', '0');

        $comarcas = Comarca::where('uf',$diligencia->comarca->uf)
                ->pluck('comarca','id');

        $servicos = Servico::get();

        return view('diligencias.edit', compact('diligencia','advogados','estados','servicos','comarcas'));
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
        $today = Carbon::today();

        //
        $this->validate($request, [
            //'comarca_id' => 'required|not_in:0',
            'titulo' => 'required|min:3|max:65',
            'descricao' => 'required|min:3',
            'num_processo' => 'required',
            'reu' => 'required',
            'advogado_id' => 'required|not_in:0', // cliente
            'orgao' => 'required',
            'prazo' => 'required|date_format:"d/m/Y H:i"|after:' . $today,
            'solicitante' => 'required',
            'orientacoes' => 'required|min:5'
        ],[
            'comarca_id.required' => 'Você precisa selecionar uma Comarca.',
            'comarca_id.not_in' => 'Você precisa selecionar uma Comarca.',
            'titulo.required' => 'Você precisa digitar um Título.',
            'descricao.required' => 'Você precisa digitar uma Descrição.',
            'num_processo.required' => 'Você precisa digitar um Número de Processo válido.',
            'reu.required' => 'Você precisa digitar um Réu.',
            'orgao.required' => 'Você precisa digitar um Órgão.',
            'prazo.required' => 'Você precisa digitar um Prazo.',
            'solicitante.required' => 'Você precisa digitar um Solicitante.',
            'orientacoes.required' => 'Você precisa digitar um mínimo de Orientações.',
            'advogado_id.required' => 'Você precisa selecionar um Advogado cliente.',
            'advogado_id.not_in' => 'Você precisa selecionar um Advogado cliente.',
        ]);

        $data = Input::only(
            'comarca_id',
            'titulo',
            'descricao',
            'num_integracao',
            'num_processo',
            'prazo',
            'advogado_id',
            'solicitante',
            'reu',
            'orgao',
            'local_orgao',
            'vara',
            'orientacoes'
        );

        // Prazo to pattern
        if (!empty($data['prazo'])) {
            $data['prazo'] = Carbon::createFromFormat('d/m/Y h:i',$data['prazo']);
        }

        // Create
        $save = Diligencia::where('id',$id)->update($data);

        if ($save) {

            // Treat File Uploads
            if ($request->hasFile('files')) {

                $files = Input::file('files');
                $files_ids = [];

                foreach ($files as $file) {

                    //$filename = $file->store('files');
                    $name = Storage::disk('uploads')->put($id, $file, 'public');

                    $new_file = File::create([
                        'titulo' => 'Anexo em D-' . $id,
                        'descricao' => 'Anexo em Diligência ' . $id,
                        'filename' => $name,
                        'user_id' => Auth::user()->id
                    ]);

                    $files_ids[] = $new_file->id;
                }
            }

            // Attach files
            if (!empty($files_ids)) {
                // Attach files to this Diligencia
                foreach ($files_ids as $file) {
                    $save->files()->attach($file);
                }
            }

            // Se foi cadastrado pelo cliente
            if (Auth::user()->level == 2)
                return redirect()->route('dashboard_cliente')->with('message', 'Nova Diligência criada com sucesso.');
            else
                return redirect()->route('diligencias.index')->with('message', 'Nova Diligência criada com sucesso.');
        }
        else {
            return redirect()->back()->with('message','Algo aconteceu de errado.');
        }
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

        $diligencia = Diligencia::where('id',$id)->first();

        $diligencia->update([
            'status_id' => '3'
        ]);

        $diligencia = Diligencia::where('id',$id)->first();

        // Dispara emails
        Email::setupAndFire('B_1', ['type' => 'advogado_id', 'id' => $diligencia->advogado_id], $diligencia);
        Email::setupAndFire('B_2', ['type' => 'correspondente_id', 'id' => $diligencia->correspondente_id], $diligencia);

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

        $diligencia = Diligencia::where('id',$id)->first();

        $diligencia->update([
            'status_id' => '4'
        ]);

        $diligencia = Diligencia::where('id',$id)->first();

        // Dispara emails
        Email::setupAndFire('C_3', ['type' => 'advogado_id', 'id' => $diligencia->advogado_id], $diligencia);
        Email::setupAndFire('C_4', ['type' => 'correspondente_id', 'id' => $diligencia->correspondente_id], $diligencia);

        return redirect()->back()->with('message', 'Checkin efetuado com sucesso.');
    }

    /**
     * Correspondente conclui uma diligencia
     *
     * @param $id
     */
    public function concluir(Request $request, $id)
    {
        if (!$id)
            abort(403,'wat');

        $data = Input::all();

        $diligencia = Diligencia::where('id',$id)->first();

        $diligencia->update([
            'status_id' => '8',
            'realizado_sucesso' => $data['realizado_sucesso'],
            'realizador_nome' => $data['realizador_nome'],
            'realizador_telefone' => $data['realizador_telefone'],
            'realizador_email' => $data['realizador_email'],
        ]);

        // Treat File Uploads
        if ($request->hasFile('files')) {

            $files = Input::file('files');
            $files_ids = [];

            foreach ($files as $file) {

                //$filename = $file->store('files');
                $name = Storage::disk('uploads')->put($id, $file, 'public');

                $new_file = File::create([
                    'titulo' => 'Anexo em D-' . $id,
                    'descricao' => 'Anexo em Diligência ' . $id,
                    'filename' => $name,
                    'user_id' => Auth::user()->id
                ]);

                $files_ids[] = $new_file->id;
            }
        }

        $diligencia = Diligencia::where('id',$id)->first();

        // Attach files
        if (!empty($files_ids)) {
            // Attach files to this Diligencia
            foreach ($files_ids as $file) {
                $diligencia->files()->attach($file);
            }
        }

        // Dispara emails
        Email::setupAndFire('R_1', ['type' => 'correspondente_id', 'id' => $diligencia->correspondente_id], $diligencia);
        Email::setupAndFire('R_2', ['type' => 'advogado_id', 'id' => $diligencia->advogado_id], $diligencia);

        return redirect()->back()->with('message', 'Diligência concluída com sucesso. Aguarde decisão da revisão.');
    }

    /**
     * Correspondente resolve uma diligencia em pedido de revisão
     *
     * @param $id
     */
    public function resolver(Request $request, $id)
    {
        if (!$id)
            abort(403,'wat');

        $data = Input::all();

        // Treat File Uploads
        if ($request->hasFile('files')) {

            $files = Input::file('files');
            $files_ids = [];

            foreach ($files as $file) {

                //$filename = $file->store('files');
                $name = Storage::disk('uploads')->put($id, $file, 'public');

                $new_file = File::create([
                    'titulo' => 'Anexo em D-' . $id,
                    'descricao' => 'Anexo em Diligência ' . $id,
                    'filename' => $name,
                    'user_id' => Auth::user()->id
                ]);

                $files_ids[] = $new_file->id;
            }
        }

        $diligencia = Diligencia::where('id',$id)->first();

        // Attach files
        if (!empty($files_ids)) {
            // Attach files to this Diligencia
            foreach ($files_ids as $file) {
                $diligencia->files()->attach($file);
            }
        }

        $diligencia->update([
            'status_id' => '8',
            'revisao_resolucao' => $data['revisao_resolucao'],
        ]);

        $diligencia = Diligencia::where('id',$id)->first();

        // Dispara email
        Email::setupAndFire('R_1', ['type' => 'correspondente_id', 'id' => $diligencia->correspondente_id], $diligencia);

        return redirect()->back()->with('message', 'Diligência resolvida com sucesso. Aguarde decisão da revisão.');
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

        $diligencia = Diligencia::where('id',$id)->first();

        // Cria crédito
        Pagamento::create([
            'diligencia_id' => $id,
            'authorized_id' => Auth::user()->id,
            'receiver_id' => $diligencia->correspondente_id,
            'tipo' => 'C'
        ]);

        // Dispara emails
        Email::setupAndFire('P_1', ['type' => 'correspondente_id', 'id' => $diligencia->correspondente_id], $diligencia);
        Email::setupAndFire('P_2', ['type' => 'advogado_id', 'id' => $diligencia->advogado_id], $diligencia);

        return redirect()->back()->with('message', 'Diligência aprovada com sucesso. O financeiro será acionado como Pagamento Autorizado.');
    }

    /**
     * Revisar e devolver uma diligencia
     *
     * @param $id
     */
    public function devolver(Request $request, $id)
    {
        if (!$id)
            abort(403,'wat');

        $data = Input::all();

        // Treat File Uploads
        if ($request->hasFile('files')) {

            $files = Input::file('files');
            $files_ids = [];

            foreach ($files as $file) {

                //$filename = $file->store('files');
                $name = Storage::disk('uploads')->put($id, $file, 'public');

                $new_file = File::create([
                    'titulo' => 'Anexo em D-' . $id,
                    'descricao' => 'Anexo em Diligência ' . $id,
                    'filename' => $name,
                    'user_id' => Auth::user()->id
                ]);

                $files_ids[] = $new_file->id;
            }
        }

        $diligencia = Diligencia::where('id',$id)->first();

        // Attach files
        if (!empty($files_ids)) {
            // Attach files to this Diligencia
            foreach ($files_ids as $file) {
                $diligencia->files()->attach($file);
            }
        }

        // Devolvida
        if (isset($data['revisao_instrucoes']) && !empty($data['revisao_instrucoes'])) {
            $diligencia->update([
                'status_id' => '9',
                'revisao_instrucoes' => $data['revisao_instrucoes']
            ]);
        }

        $diligencia = Diligencia::where('id',$id)->first();

        // Dispara emails
        Email::setupAndFire('D_1', ['type' => 'correspondente_id', 'id' => $diligencia->correspondente_id], $diligencia);
        Email::setupAndFire('D_2', ['type' => 'advogado_id', 'id' => $diligencia->advogado_id], $diligencia);

        return redirect()->back()->with('message', 'Diligência devolvida. O correspondente será acionado para revisar o trabalho.');
    }


    /**
     * Revisar e devolver uma diligencia
     *
     * @param $id
     */
    public function selecionarCorrespondente($correspondente_id,$diligencia_id)
    {
        if (!$correspondente_id || !$diligencia_id)
            abort(403,'Erro');

        $diligencia = Diligencia::where('id',$diligencia_id)->update([
            'correspondente_id' => $correspondente_id,
            'status_id' => '2'
        ]);

        $diligencia = Diligencia::where('id',$diligencia_id)->first();

        // Dispara emails
        Email::setupAndFire('A_2', ['type' => 'correspondente_id', 'id' => $diligencia->correspondente_id], $diligencia);

        return redirect()->back()->with('message', 'Correspondente Selecionado com sucesso. O correspondente será notificado por email e deverá aceitar o trabalho.');
    }

    /**
     * get dates for daterange picker on grid
     *
     * @return array
     */
    public function getDates()
    {
        $carbon = new Carbon();
        $prev_month = Carbon::now()->startOfMonth()->subWeek();
        $today = Carbon::now();
        $res = [
            'format' => 'YYYY-MM-DD',
            'ranges' => [
                'previous_month' => [
                    'Mês anterior (' . $prev_month->format('F') . ')',
                    [
                        $prev_month->startOfMonth()->format('Y-m-d'),
                        $prev_month->endOfMonth()->format('Y-m-d'),
                    ]
                ],
                'current_month' => [
                    'Mês atual (' . date('F'). ')',
                    [
                        $carbon->startOfMonth()->format('Y-m-d'),
                        $carbon->endOfMonth()->format('Y-m-d')
                    ]
                ],/*
                'last_week' => [
                    'This Week',
                    [
                        $carbon->startOfWeek()->format('Y-m-d'),
                        $carbon->endOfWeek()->format('Y-m-d')
                    ]
                ],*/
                'next_14' => [
                    'Próximos 14 dias',
                    [
                        $today->format('Y-m-d'),
                        Carbon::now()->addDays(13)->format('Y-m-d')
                    ]
                ],
                'today' => [
                    'Hoje',
                    [
                        $today->format('Y-m-d'),
                        $today->format('Y-m-d')
                    ]
                ],

            ],
        ];

        return $res;
    }

    public function getUrgenciaList()
    {
        return [
            'Crítica' => 'Crítica',
            'Urgente' => 'Urgente',
            'Alta' => 'Alta',
            'Média' => 'Média',
            'Normal' => 'Normal'
        ];
    }

    /**
     * Cancela uma diligencia
     *
     * @param $id
     */
    public function cancelar($id)
    {
        $diligencia = Diligencia::where('id',$id)->first();

        $diligencia->update([
            'status_id' => '12'
        ]);

        // Dispara emails
        Email::setupAndFire('X_1', ['type' => 'correspondente_id', 'id' => $diligencia->correspondente_id], $diligencia);
        Email::setupAndFire('X_2', ['type' => 'advogado_id', 'id' => $diligencia->advogado_id], $diligencia);

       return redirect()->action('DiligenciasController@index');
    }
}
