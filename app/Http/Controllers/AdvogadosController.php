<?php

namespace App\Http\Controllers;

use App\Advogado;
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
        # Some params may be predefined, other can be controlled using grid components
        $query = (new Advogado())
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
                        ->setName('telefone')
                        ->setLabel('Telefone')
                        ->setSortable(true)
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
                                    (new HtmlTag())
                                        ->setTagName('button')
                                        ->setAttributes([
                                            'type' => 'submit',
                                            # Some bootstrap classes
                                            'class' => 'btn btn-primary'
                                        ])
                                        ->setContent('Filter')
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
}
