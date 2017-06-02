<?php

namespace App\Console\Commands;

use App\Comarca;
use App\Correspondente;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;

class ImportCorrespondentes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:correspondentes';

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
        ini_set('memory_limit', '1024M');

        //
        $this->runData();

        $this->info('Importação finalizada');
    }

    /**
     * Le a planilha e povoa a database
     *
     * @return string
     */
    public function runData()
    {
        $results = '';

        $file = storage_path('app/files/correspondentes2.xlsx');

        \Maatwebsite\Excel\Facades\Excel::load( $file, function($reader) {

            // Getting all results
            $results = $reader->get();

            foreach($results as $result) {

                if (!$result->comarca)
                    continue;

                $this->info('comarca: ' . $result->comarca);

                // Busca pela comarca
                $comarca = Comarca::where('comarca',utf8_encode($result->comarca))
                    ->first();

                // Create Comarca if needed
                if (!$comarca || $comarca->count() <= 0) {
                    $this->info('> Criando comarca: ' . $result->comarca);
                    $comarca = Comarca::create(['comarca' => $result->comarca]);
                }

                // Verifica se o Correspondente já existe
                $user_exists = User::where('email', $result->email)
                    ->has('correspondente')
                    ->with('correspondente')
                    ->first();

                // Existe?
                if ($user_exists && $user_exists->count() > 0) {

                    $this->info('> Correspondente existe: ' . $user_exists->nome   );

                    // Já tem a comarca?
                    if ($user_exists->correspondente->comarcas->contains($result->comarca)) {
                        $this->info('> Correspondente '. $result->nome . ' já existente nesta comarca: ' . $result->comarca);
                        continue;
                    }
                    // Adiciona a comarca
                    else {
                        $this->info('Comarca ' . $comarca->id . ' adicionada ao usuario');
                        $user_exists->correspondente->comarcas()->attach($comarca->id);
                    }
                }

                $this->info('> Correspondente Não existe. Preparando para criar: ' . $result->nome   );

                // Prepara os dados
                $user['nome'] = $result->nome;
                $user['email'] = $result->email;
                $user['phone'] = $result->phone;
                $user['cpf'] = $result->cpf;
                $user['password'] = Hash::make('12345');

                $data['nome'] = $result->nome;
                //$data['comarca_id'] = $comarca->id;
                $data['advogado'] = $result->advogado;
                $data['preposto'] = $result->preposto;
                $data['diligencia'] = $result->diligencia;
                $data['cnpj'] = $result->cnpj;

                $this->info('> Correspondente ' . $result->nome . ' preparado'   );

                // Cria o correspondente
                $correspondente = Correspondente::create($data);

                $this->info('> Correspondente ' . $result->nome . ' criado'   );

                // Usuario não existe, cria
                if (!$user_exists || $user_exists->count() <= 0) {

                    $this->info('> Criando usuário: ' . $result->nome   );

                    $user['correspondente_id'] = $correspondente->id;

                    // Cria o user
                    $user_result = User::create($user);
                }
                else {
                    $this->info('> Usuário Existe: ' . $user_exists->email   );
                }

                $this->info('Vinculando servicos do correspondente ' . $correspondente->id);

                $correspondente = Correspondente::where('id',$correspondente->id)
                    ->with('servicos')
                    ->with('user')
                    ->first();

                // Vincula os serviços
                if (!empty($data['advogado'])) {
                    $valor = str_replace('R$', '', $data['advogado']);
                    $valor = number_format( (int)$valor, 0,'', '');
                    $correspondente->servicos()->attach(2,['valor' => $valor, 'comarca_id' => $comarca->id]);
                }

                if (!empty($data['preposto'])){
                    $valor = str_replace('R$', '', $data['preposto']);
                    $valor = number_format( (int)$valor, 0,'', '');
                    $correspondente->servicos()->attach(1,['valor' => $valor, 'comarca_id' => $comarca->id]);
                }

                if (!empty($data['diligencia'])) {
                    $valor = str_replace('R$', '', $data['diligencia']);
                    $valor = number_format( (int)$valor, 0,'', '');
                    $correspondente->servicos()->attach(4,['valor' => $valor, 'comarca_id' => $comarca->id]);
                }

                if (!empty($data['advogado_preposto'])){
                    $valor = str_replace('R$', '', $data['advogado_preposto']);
                    $valor = number_format( (int)$valor, 0,'', '');
                    $correspondente->servicos()->attach(3,['valor' => $valor, 'comarca_id' => $comarca->id]);
                }

                $this->info('Vinculando comarca ' . $comarca->id . ' ao correspondente ' . $correspondente->id);

                // Vincula a comarca ao correspondente
                $correspondente->comarcas()->attach($comarca->id);

                $this->info('Item ' . $result->id . ' integrado com sucesso. ');
            }

        });
    }


    public function get_data() {

        $file_n = storage_path('app/files/correspondentes.csv');
        $file = fopen($file_n, "r");

        $all_data = $result = array();
        $row=1;

        while ( ($data = fgetcsv($file, 200, ",")) !==FALSE) {

            $num = count($data);
            //echo "<p> $num campos na linha $row: <br /></p>\n";
            $row++;

            // Skip Headers
            if ($num == 1) {
                continue;
            }

            $tudo = explode(';', $data);

            foreach ($tudo as $linha) {
                echo $linha;
            }

            dd($result);
            //array_push($row, $all_data);
        }
        fclose($file);

        return $all_data;
    }

}

use PHPExcel_Cell;
use PHPExcel_Cell_DataType;
use PHPExcel_Cell_IValueBinder;
use PHPExcel_Cell_DefaultValueBinder;

class MyValueBinder extends PHPExcel_Cell_DefaultValueBinder implements PHPExcel_Cell_IValueBinder
{
    public function bindValue(PHPExcel_Cell $cell, $value = null)
    {
        if (is_numeric($value))
        {
            $cell->setValueExplicit($value, PHPExcel_Cell_DataType::TYPE_NUMERIC);

            return true;
        }
        else {
            $cell->setValueExplicit($value, PHPExcel_Cell_DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }
}