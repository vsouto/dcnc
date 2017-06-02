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
            'status' => 'Sondagem',
            'class' => 'sondagem',
        ]);
        \App\Status::create([
            'status' => 'Aguardando Confirmação',
            'class' => 'aguardando-confirmacao',
        ]);
        \App\Status::create([
            'status' => 'Aguardando Checkin',
            'class' => 'aguardando-checkin',
        ]);
        \App\Status::create([
            'status' => 'Aguardando Conclusão',
            'class' => 'aguardando-conclusao',
        ]);
        \App\Status::create([
            'status' => 'Sem Checkin',
            'class' => 'sem-checkin',
        ]);
        \App\Status::create([
            'status' => 'Em Negociação',
            'class' => 'em-negociacao',
        ]);
        \App\Status::create([
            'status' => 'Atrasada',
            'class' => 'atrasada',
        ]);

        \App\Status::create([
            'status' => 'Em Revisão',
            'class' => 'em-revisao',
        ]);

        \App\Status::create([
            'status' => 'Devolvida',
            'class' => 'devolvida',
        ]);
        \App\Status::create([
            'status' => 'Pagamento Autorizado',
            'class' => 'pagamento-autorizado',
        ]);
        \App\Status::create([
            'status' => 'Efetivada',
            'class' => 'efetivada',
        ]);
        \App\Status::create([
            'status' => 'Cancelada',
            'class' => 'cancelada',
        ]);



    }
}
