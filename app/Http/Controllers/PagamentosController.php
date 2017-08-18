<?php

namespace App\Http\Controllers;

use App\Correspondente;
use App\Diligencia;
use App\Email;
use App\Pagamento;
use App\Status;
use App\User;
use Illuminate\Http\Request;

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

class PagamentosController extends Controller
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
        $query = (new Pagamento())
            ->with('diligencia')
            ->has('diligencia')
            ->newQuery();

        # Instantiate & Configure Grid
        $grid = new Grid(
            (new GridConfig())
                # Grids name used as html id, caching key, filtering GET params prefix, etc
                # If not specified, unique value based on file name & line of code will be generated
                ->setName('Pagamentos')
                # See all supported data providers in sources
                ->setDataProvider(new EloquentDataProvider($query))
                # Setup caching, value in minutes, turned off in debug mode
                //->setCachingTime(5)
                # Setup table columns
                ->setColumns([
                    # simple results numbering, not related to table PK or any obtained data
                    new IdFieldConfig(),
                    (new FieldConfig())
                        ->setName('diligencia_id')
                        ->setLabel('Diligência')
                        ->addFilter(
                            (new FilterConfig())
                                ->setName('diligencia')
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                            if (!$val)
                                return '';

                            $diligencia = Diligencia::where('id', $val)->first();

                            return "<a href='".route('diligencias.show',['id' => $diligencia->id])."' class='underline-text'>" . $val . " - " . $diligencia->titulo . "</a>";
                        })
                    ,
                    (new FieldConfig)
                        ->setName('status_id')
                        ->setLabel('Status')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                            $status = Status::where('id',$row->getSrc()->diligencia->status_id)->first();

                            return "<span class='badge {$status->class} edit-status'>{$status->status}</span>";

                        }),
                    (new FieldConfig)
                        ->setName('authorized_id')
                        ->setLabel('Autorizado Por')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                            if (!$val)
                                return '';

                            $user = User::where('id', $val)->first();

                            return $user->nome;
                        })
                    ,
                    (new FieldConfig)
                        ->setName('receiver_id')
                        ->setLabel('Recebedor')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                            if (!$val)
                                return '';

                            $correspondente = Correspondente::where('id', $val)->first();

                            return $correspondente->nome;
                        })
                    ,
                    (new FieldConfig)
                        ->setName('tipo')
                        ->setLabel('Tipo')
                        ->setSortable(true)
                        ->setCallback(function ($val) {
                            if (!$val)
                                return '';

                            if ($val == 'C')
                                return "<span class='badge badge-info edit-status'>Crédito</span>";
                            else
                                return "<span class='badge badge-warning edit-status'>Débito</span>";
                        })
                    ,
                    (new FieldConfig)
                        ->setName('efetivada')
                        ->setLabel('Efetivada')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                            //$diligencia = Diligencia::where('id',$row->getSrc()->diligencia_id)->first();

                            // Não efetivada
                            if (!$val) {

                                return '<span class="btn btn-success efetivar" data-ref="'.$row->getSrc()->id.'">Efetivar</span>';
                            }
                            else
                                return 'Efetivada';
                        })
                    ,
                    (new FieldConfig)
                        ->setName('valor')
                        ->setLabel('Valor')
                        ->setSortable(true)
                        ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                            if (!$val)
                                return '';

                            return 'R$ ' . $val;
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

        return view('pagamentos.index',compact('grid'));
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

    /**
     * Cancela uma diligencia
     *
     * @param $id
     */
    public function efetivar($id)
    {
        if (!$id)
            abort(503);

        $pagamento = Pagamento::where('id',$id)->first();

        if (!$pagamento)
            abort(503);

        $diligencia = Diligencia::where('id',$pagamento->diligencia_id)->first();

        $diligencia->update([
            'status_id' => '11'
        ]);

        // Update pagamento
        $pagamento->update(['efetivada' => '1']);

        // Dispara emails
        Email::setupAndFire('Z_1', ['type' => 'correspondente_id', 'id' => $diligencia->correspondente_id], $diligencia);
        Email::setupAndFire('Z_2', ['type' => 'advogado_id', 'id' => $diligencia->advogado_id], $diligencia);

        return redirect()->back();
    }
}
