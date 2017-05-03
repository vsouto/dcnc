<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Status::create([
            'status' => 'Sondagem'
        ]);
        \App\Status::create([
            'status' => 'Aguardando Confirmação'
        ]);

        \App\Status::create([
            'status' => 'Aguardando Checkin'
        ]);

        \App\Status::create([
            'status' => 'Aguardando Conclusão'
        ]);

        \App\Status::create([
            'status' => 'Sem Checkin'
        ]);

        \App\Status::create([
            'status' => 'Em Negociação'
        ]);

        \App\Status::create([
            'status' => 'Atrasada'
        ]);

        \App\Status::create([
            'status' => 'Em Revisão'
        ]);

        \App\Status::create([
            'status' => 'Devolvida'
        ]);
        \App\Status::create([
            'status' => 'Pagamento Autorizado'
        ]);
        \App\Status::create([
            'status' => 'Efetivada'
        ]);
        \App\Status::create([
            'status' => 'Cancelada'
        ]);



    }
}
