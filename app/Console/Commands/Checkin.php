<?php

namespace App\Console\Commands;

use App\Configuracoes;
use App\Diligencia;
use App\Email;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Checkin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:in';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cobrança de CheckIn do Correspondente';

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
        // check for CheckIns
        $this->checkIns();
    }

    public function checkIns()
    {
        // Get config
        $config = Configuracoes::where('chave','Checkin_Correspondente')->first();

        if ($config && isset($config->valor)) {
            $valor = $config->valor;
            $this->info('Config encontrada: ' . $valor);
        }
        else {
            $valor = 8;
            $this->info('Config NÃO encontrada. Utilizando padrão 8');
        }

        // Busca AUDIENCIAS as que passaram do prazo + horas de margem
        $checkins_atrasados = DB::table('diligencias')
            ->select('*')
            ->where(DB::raw('NOW()'),'>=',DB::raw('DATE_SUB(prazo, INTERVAL '.$valor . ' HOUR)'))
            ->where('checkin_emitido','1')
            ->where('audiencia','1')
            ->get();

        foreach ($checkins_atrasados as $diligencia) {

            Diligencia::where('id',$diligencia->id)->update(['checkin_emitido' => '1']);

            // Email para cobrar Checkin
            Email::setupAndFire('C_1', ['type' => 'correspondente_id', 'id' => $diligencia->correspondente_id], $diligencia);
        }

    }
}
