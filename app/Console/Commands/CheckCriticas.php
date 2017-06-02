<?php

namespace App\Console\Commands;

use App\Diligencia;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckCriticas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:criticas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Diligencias Críticas';

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
        // Verifica as urgencias e faz as alterações
        $this->checkDiligenciasUrgentes();

        // Verficai os tempos das sondagens
        //$this->checkDiligenciasSondagens();
    }

    /**
     * Check Diligencias Status
     */
    public function checkDiligenciasUrgentes()
    {
        $prazo_dia = Carbon::now()->addHours(24);
        $prazo_dois_dias = Carbon::now()->addHours(48);
        $prazo_dezoito_horas = Carbon::now()->addHours(18);
        $prazo_doze_horas = Carbon::now()->addHours(12);
        $prazo_oito_horas = Carbon::now()->addHours(8);

        /*
         * CRITICAS
         */
        // Busca diligencias com prazo menor que 8hrs
        $urgentes = Diligencia::where('prazo','<=',$prazo_oito_horas)
            ->where('urgencia','!=','Crítica')
            ->get();

        foreach ($urgentes as $urgente) {
            Diligencia::where('id',$urgente->id)->update(['urgencia' => 'Crítica']);
        }

        /*
         * URGENTES
         */
        // Busca diligencias com prazo entre 8 e 12hrs
        $urgentes = Diligencia::whereBetween('prazo',[$prazo_oito_horas,$prazo_doze_horas])
            ->where('urgencia','!=','Urgente')
            ->get();

        foreach ($urgentes as $urgente) {
            Diligencia::where('id',$urgente->id)->update(['urgencia' => 'Urgente']);
        }

    }

    /**
     * Check Sondagens de Diligencias
     */
    public function checkDiligenciasSondagens()
    {

    }
}
