<?php

namespace App\Console\Commands;

use App\Configuracoes;
use App\Diligencia;
use App\Email;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckAtrasos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:atrasos';

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
        // Verifica diligencias atrasadas
        $this->checkAtrasadas();

        // Verifica diligencias não confirmadas por correspondentes
        $this->checkNaoConfirmados();
    }

    /**
     * Checa diligencias não confirmadas por correspondentes
     */
    public function checkNaoConfirmados()
    {
        // Get config
        $config = Configuracoes::where('chave','Aceitacao_Correspondente')->first();

        if ($config && isset($config->valor)) {
            $valor = $config->valor;
            $this->info('Config encontrada: ' . $valor);
        }
        else {
            $valor = 8;
            $this->info('Config NÃO encontrada. Utilizando padrão 8');
        }

        // Busca as diligencias onde as sondagens ultrapassaram o tempo permitido
        $atrasadas = DB::table('diligencias')
            ->select('*')
            ->where(DB::raw('NOW()'),'>=',DB::raw('DATE_ADD(sondagem, INTERVAL '.$valor . ' HOUR)'))
            ->get();

        if ($atrasadas && sizeof($atrasadas) > 0) {

            // Atualiza cada uma como em Negociação
            foreach ($atrasadas as $atrasada) {

                $diligencia = Diligencia::where('id',$atrasada->id)
                    ->update([
                        'status_id' => '6'
                    ]);

                // Email para informa Em Negociação
                Email::setupAndFire('A_3', ['type' => 'correspondente_id', 'id' => $atrasada->correspondente_id], $atrasada);
            }
        }
    }

    /**
     * Checa por diligencias atrasadas, a partir da config de horas definida no setup
     */
    public function checkAtrasadas()
    {

        // Get config
        $config = Configuracoes::where('chave','Atraso_Diligencia')->first();

        if ($config && isset($config->valor)) {
            $valor = $config->valor;
            $this->info('Config encontrada: ' . $valor);
        }
        else {
            $valor = 8;
            $this->info('Config NÃO encontrada. Utilizando padrão 8');
        }

        // Busca as que passaram do prazo + horas de margem
        $atrasadas = DB::table('diligencias')
                ->select('*')
                ->where(DB::raw('NOW()'),'>=',DB::raw('DATE_ADD(prazo, INTERVAL '.$valor . ' HOUR)'))
                ->get();

        if ($atrasadas && sizeof($atrasadas) > 0) {

            // Atualiza cada uma como Atrasada
            foreach ($atrasadas as $atrasada) {

                $diligencia = Diligencia::where('id',$atrasada->id)
                    ->update([
                        'status_id' => '7'
                    ]);


                Email::setupAndFire('A_3', ['type' => 'correspondente_id', 'id' => $atrasada->correspondente_id], $atrasada);
            }
        }
    }
}
