<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Comarca;
use App\Configuracoes;
use App\Correspondente;
use App\Diligencia;
use App\Servico;
use App\Status;
use App\User;
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

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Dashboard normal
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        // Correspondente
        if (Auth::user()->level == 1)
            return redirect()->action('PagesController@dashboard_correspondente');

        // Cliente
        if (Auth::user()->level == 2)
            return redirect()->action('PagesController@dashboard_cliente');

        $correspondentes_count = Correspondente::count();

        $correspondentes_overprice = Correspondente::overprice()->get()->count();

        //$correspondentes_not_overprice = sizeof(Correspondente::overprice(true));
        $correspondentes_rating_avg = Correspondente::avg('rating');

        $correspondentes_em_uso = Correspondente::has('diligencias')->count();

        $correspondentes_mais_atrasos = Correspondente::orderBy('atrasos','DESC')
            ->with('user')->has('user')->take(8)->get();

        $diligencias_destaque = Diligencia::whereIn('urgencia',['Crítica','Urgente'])
            ->take(10)
            ->get();

        $statuses = Status::all();

        //$correspondentes_menos_ocupados = Correspondente::take(6)->get();

        $clientes_mais_atrasos = Cliente::where('atrasos','>','0')->orderBy('atrasos','DESC')->get();


        return view('pages.home', compact(
            'correspondentes_count','diligencias_destaque', 'statuses',
            'correspondentes_menos_ocupados',
            'correspondentes_overprice', 'correspondentes_not_overprice','correspondentes_em_uso',
            'correspondentes_rating_avg',
            'correspondentes_mais_atrasos',
            'clientes_mais_atrasos'));
    }

    /**
     * Dashboard Correspondente
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function dashboard_correspondente()
    {
        if (!Auth::user()->correspondente_id || empty(Auth::user()->correspondente_id))
            return abort(403, 'Existe um erro em sua conta');

        # Some params may be predefined, other can be controlled using grid components
        $query = (new Diligencia())
            ->with('servicos')
            ->with('correspondente')
            ->with('advogado')
            ->whereNotNull('correspondente_id')
            ->where('correspondente_id',Auth::user()->correspondente_id)
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
                //->setCachingTime(5)
                # Setup table columns
                ->setColumns([
                    # simple results numbering, not related to table PK or any obtained data
                    (new FieldConfig)
                        ->setName('actions')
                        ->setLabel('Ações')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                            $button1 = '<div style="float: left">'.
                                '<span data-ref="'.route('diligencias.show', ['id' => $row->getSrc()->id]).'" class="btn btn-sm btn-info btn-rounded view-diligencia">'.
                                '<i class="fa fa-eye"></i></span></div> ';

                            return '<div style="min-width: 90px">' . $button1 . '</div>';
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
                            if (!$row->getSrc()->comarca_id)
                                return '';

                            $comarca = Comarca::where('id',$row->getSrc()->comarca_id)->first();

                            return $comarca->comarca;
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

                            if (!$row->getSrc()->servicos)
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
                            if (!$row->getSrc()->servicos || empty($row->getSrc()->servicos) || $row->getSrc()->servicos->count() <= 0)
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

                            if (!$row->getSrc()->advogado)
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

        return view('pages.dashboard_correspondente', compact('grid'));
    }

    /**
     * Dashboard Cliente
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function dashboard_cliente()
    {
        if (!Auth::user()->cliente_id || empty(Auth::user()->cliente_id))
            return abort(403, 'Existe um erro em sua conta');

        $cliente = Cliente::where('id',Auth::user()->cliente_id)->first();

        if (!$cliente)
            return abort(403, 'Existe um erro em sua conta');

        // Se o user é o cliente master
        if (Auth::user()->id == $cliente->user_id) {

            $advogados = [];
            $advogados_cliente = User::where('cliente_id',$cliente->id)->select('id')->get()->toArray();

            foreach ($advogados_cliente as $adv) {
                $advogados[] = $adv['id'];
            }

            # Some params may be predefined, other can be controlled using grid components
            $query = (new Diligencia())
                ->with('servicos')
                ->with('correspondente')
                ->with('advogado')
                ->whereIn('advogado_id',$advogados)
                ->orderBy('created_at','DESC')
                ->newQuery();
        }
        else {
            # Some params may be predefined, other can be controlled using grid components
            $query = (new Diligencia())
                ->with('servicos')
                ->with('correspondente')
                ->with('advogado')
                ->where('advogado_id',Auth::user()->id)
                ->orderBy('created_at','DESC')
                ->newQuery();
        }


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
                    (new FieldConfig)
                        ->setName('actions')
                        ->setLabel('Ações')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                            $button1 = '<div style="float: left">'.
                                '<span data-ref="'.route('diligencias.show', ['id' => $row->getSrc()->id]).'" class="btn btn-sm btn-info btn-rounded view-diligencia">'.
                                '<i class="fa fa-eye"></i></span></div> ';

                            return '<div style="min-width: 90px">' . $button1 . '</div>';
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

                            if (!$row->getSrc()->servicos)
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
                            if (!$row->getSrc()->servicos || empty($row->getSrc()->servicos) || $row->getSrc()->servicos->count() <= 0)
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

                            if (!$row->getSrc()->advogado)
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

        return view('pages.dashboard_cliente', compact('grid'));
    }

    //
    public function dashboard()
    {
        return view('pages.dashboard');
    }

    public function setup()
    {

        $servicos = Servico::get();

        $configs = Configuracoes::get();

        return view('pages.setup', compact('servicos','configs'));
    }

}

