<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ImportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users';

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
        $this->runData();
    }


    /**
     * Le a planilha e povoa a database
     *
     * @return string
     */
    public function runData()
    {
        $results = '';

        $file = storage_path('app/files/usuarios.xlsx');

        \Maatwebsite\Excel\Facades\Excel::load( $file, function($reader) {

            // Getting all results
            $results = $reader->get();

            foreach($results as $result) {

                var_dump($result->id);
                var_dump($result->cliente_id);
                /*
                                switch ($result->cliente_id) {
                                    case 'SOCIA':
                                    case 'ADVOGADA':
                                    case 'ADVOGADO':
                                        $level = 2;
                                    default:
                                        $level = 2;
                                }
                                */

                $senha = Hash::make('12345');

                $exists = User::where('email',$result->email)->first();

                if (!$exists) {
                    $user = User::create([
                        'nome' => $result->nome,
                        'email' => $result->email,
                        'level' => '2',
                        'phone' => $result->telefone,
                        'endereco' => $result->endereco,
                        'password' => $senha,
                        //'cidade' => $result->cidade,
                        //'estado' => $result->estado,

                    ]);
                }


                $this->info('Item ' . $result->id . ' integrado com sucesso. ');
            }

        });
    }
}
