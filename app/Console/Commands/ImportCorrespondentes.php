<?php

namespace App\Console\Commands;

use App\Comarca;
use App\Correspondente;
use Illuminate\Console\Command;
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

        $file = storage_path('app/files/correspondentes.xlsx');

        \Maatwebsite\Excel\Facades\Excel::load( $file, function($reader) {

            // Getting all results
            $results = $reader->get();

            foreach($results as $result) {

                if (!$result->comarca)
                    continue;

                $this->info('comarca: ' . $result->comarca);

                // Busca pela comarca
                $comarca = Comarca::where('comarca',$result->comarca)->first();

                // create
                if (!$comarca)
                    $comarca = Comarca::create(['comarca' => $result->comarca]);
                else {
                    // Verifica se o correspondente existe
                    $existe = Correspondente::where('comarca_id', $comarca->id)
                        ->where('nome',$result->nome)
                        ->first();

                    if ($existe)
                        continue;
                }

                // Cria o user
                $user['nome'] = $result->nome;
                $user['email'] = $result->nome;
                $user['phone'] = $result->nome;
                $user['email'] = $result->nome;

                $data['nome'] = $result->nome;
                $data['comarca_id'] = $comarca->id;

                Correspondente::create($data);
            }

        });

        return $results;
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