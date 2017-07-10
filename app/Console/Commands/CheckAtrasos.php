<?php

namespace App\Console\Commands;

use App\Configuracoes;
use App\Diligencia;
use Carbon\Carbon;
use Illuminate\Console\Command;

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
        //
        $this->checkAtrasadas();
    }

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


        // Define time
        $horas_atrasadas = Carbon::now()->addHours($valor);

        // Busca diligencias com prazo estourado e a partir da margem definida
        $atrasadas = Diligencia::where('prazo','<=',$horas_atrasadas)
            ->where('status_id','>=', '3')
            ->get();

        if ($atrasadas && $atrasadas->count() > 0) {

            // Atualiza cada uma como Atrasada
            foreach ($atrasadas as $atrasada) {
                $atrasada->update([
                    'status_id' => '7'
                ]);
            }
        }
    }
}
