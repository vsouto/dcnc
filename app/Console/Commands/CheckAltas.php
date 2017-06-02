<?php

namespace App\Console\Commands;

use App\Diligencia;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckAltas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:altas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->checkDiligenciasAltas();
    }

    /**
     * Check Diligencias Status
     */
    public function checkDiligenciasAltas()
    {

        $prazo_dia = Carbon::now()->addHours(24);
        $prazo_dois_dias = Carbon::now()->addHours(48);
        $prazo_dezoito_horas = Carbon::now()->addHours(18);
        $prazo_doze_horas = Carbon::now()->addHours(12);
        $prazo_oito_horas = Carbon::now()->addHours(8);

        /*
         * ALTAS
         */
        // Busca diligencias com prazo entre 24hrs e 48hrs
        $urgentes = Diligencia::whereBetween('prazo',[$prazo_doze_horas,$prazo_dezoito_horas])
        ->where('urgencia','!=','Alta')
        ->get();

        foreach ($urgentes as $urgente) {
            Diligencia::where('id',$urgente->id)->update(['urgencia' => 'Alta']);
        }

        /*
         * MEDIAS
         */
        // Busca diligencias com prazo entre 24hrs e 48hrs
        $urgentes = Diligencia::whereBetween('prazo',[$prazo_dezoito_horas,$prazo_dia])
            ->where('urgencia','!=','Média')
            ->get();

        foreach ($urgentes as $urgente) {
            Diligencia::where('id',$urgente->id)->update(['urgencia' => 'Média']);
        }
    }
}
