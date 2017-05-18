<?php

use Illuminate\Database\Seeder;

class DiligenciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker\Factory::create();

        //
        $diligencia1 = \App\Diligencia::create([
            'titulo' => 'Teste 1',
            'descricao' => 'Entregar a poapeamwea aewaqe',
            'num_integracao' => '332',
            'prazo' => \Carbon\Carbon::now()->addDays(7),
            'advogado_id' => '1',
            'solicitante' => $faker->name,
            'reu' => $faker->name,
            'num_processo' => $faker->numberBetween(0,999),
            'orgao' => $faker->company,
            'local_orgao' => $faker->address,
            'vara' => $faker->company,
            'orientacoes' => $faker->text(230),
        ]);
        $diligencia2 = \App\Diligencia::create([
            'titulo' => 'Diligência 2',
            'descricao' => 'Entregar a poapeamwea aewaqe',
            'num_integracao' => '332',
            'prazo' => \Carbon\Carbon::now()->addDays(3),
            'advogado_id' => '1',
            'solicitante' => $faker->name,
            'correspondente_id' => '3',
            'reu' => $faker->name,
            'num_processo' => $faker->numberBetween(0,999),
            'orgao' => $faker->company,
            'local_orgao' => $faker->address,
            'vara' => $faker->company,
            'orientacoes' => $faker->text(230),
            'status_id' => '2',
        ]);
        $diligencia3 = \App\Diligencia::create([
            'titulo' => 'Contestar Carga',
            'descricao' => $faker->text(90),
            'num_integracao' => $faker->numberBetween(1,999),
            'prazo' => \Carbon\Carbon::now()->addDays(12),
            'advogado_id' => '1',
            'solicitante' => $faker->name,
            'correspondente_id' => '2',
            'reu' => $faker->name,
            'num_processo' => $faker->numberBetween(0,999),
            'orgao' => $faker->company,
            'local_orgao' => $faker->address,
            'vara' => $faker->company,
            'orientacoes' => $faker->text(230),
            'status_id' => '3',
        ]);
        $diligencia4 = \App\Diligencia::create([
            'titulo' => 'Contestar Carga',
            'descricao' => $faker->text(90),
            'num_integracao' => $faker->numberBetween(1,999),
            'prazo' => \Carbon\Carbon::now()->addDays(5),
            'advogado_id' => '1',
            'solicitante' => $faker->name,
            'correspondente_id' => '4',
            'reu' => $faker->name,
            'num_processo' => $faker->numberBetween(0,999),
            'orgao' => $faker->company,
            'local_orgao' => $faker->address,
            'vara' => $faker->company,
            'orientacoes' => $faker->text(230),
            'status_id' => '4',
        ]);
        $diligencia5 = \App\Diligencia::create([
            'titulo' => 'Contestar Entrega',
            'descricao' => $faker->text(90),
            'num_integracao' => $faker->numberBetween(1,999),
            'prazo' => \Carbon\Carbon::now()->addDays(5),
            'advogado_id' => '1',
            'solicitante' => $faker->name,
            'correspondente_id' => '4',
            'reu' => $faker->name,
            'num_processo' => $faker->numberBetween(0,999),
            'orgao' => $faker->company,
            'local_orgao' => $faker->address,
            'vara' => $faker->company,
            'orientacoes' => $faker->text(230),
            'status_id' => '5',
        ]);
        $diligencia6 = \App\Diligencia::create([
            'titulo' => 'Notificação do Consumidor',
            'descricao' => $faker->text(90),
            'num_integracao' => $faker->numberBetween(1,999),
            'prazo' => \Carbon\Carbon::now()->addDays(5),
            'advogado_id' => '1',
            'solicitante' => $faker->name,
            'correspondente_id' => '2',
            'reu' => $faker->name,
            'num_processo' => $faker->numberBetween(0,999),
            'orgao' => $faker->company,
            'local_orgao' => $faker->address,
            'vara' => $faker->company,
            'orientacoes' => $faker->text(230),
            'status_id' => '6',
        ]);
        $diligencia7 = \App\Diligencia::create([
            'titulo' => 'Notificação ao Produtor',
            'descricao' => $faker->text(90),
            'num_integracao' => $faker->numberBetween(1,999),
            'prazo' => \Carbon\Carbon::now()->addDays(5),
            'advogado_id' => '1',
            'solicitante' => $faker->name,
            'correspondente_id' => '1',
            'reu' => $faker->name,
            'num_processo' => $faker->numberBetween(0,999),
            'orgao' => $faker->company,
            'local_orgao' => $faker->address,
            'vara' => $faker->company,
            'orientacoes' => $faker->text(230),
            'status_id' => '7',
        ]);
        $diligencia = \App\Diligencia::create([
            'titulo' => 'Notificação de Despejo',
            'descricao' => $faker->text(90),
            'num_integracao' => $faker->numberBetween(1,999),
            'prazo' => \Carbon\Carbon::now()->addDays(5),
            'advogado_id' => '2',
            'solicitante' => $faker->name,
            'correspondente_id' => '2',
            'reu' => $faker->name,
            'num_processo' => $faker->numberBetween(0,999),
            'orgao' => $faker->company,
            'local_orgao' => $faker->address,
            'vara' => $faker->company,
            'orientacoes' => $faker->text(230),
            'status_id' => '9',
        ]);
        $diligencia = \App\Diligencia::create([
            'titulo' => 'Notificação de Despejo',
            'descricao' => $faker->text(90),
            'num_integracao' => $faker->numberBetween(1,999),
            'prazo' => \Carbon\Carbon::now()->addDays(5),
            'advogado_id' => '2',
            'solicitante' => $faker->name,
            'correspondente_id' => '2',
            'reu' => $faker->name,
            'num_processo' => $faker->numberBetween(0,999),
            'orgao' => $faker->company,
            'local_orgao' => $faker->address,
            'vara' => $faker->company,
            'orientacoes' => $faker->text(230),
            'status_id' => '10',
        ]);
        $diligencia = \App\Diligencia::create([
            'titulo' => 'Notificação de Despejo',
            'descricao' => $faker->text(90),
            'num_integracao' => $faker->numberBetween(1,999),
            'prazo' => \Carbon\Carbon::now()->addDays(5),
            'advogado_id' => '2',
            'solicitante' => $faker->name,
            'correspondente_id' => '1',
            'reu' => $faker->name,
            'num_processo' => $faker->numberBetween(0,999),
            'orgao' => $faker->company,
            'local_orgao' => $faker->address,
            'vara' => $faker->company,
            'orientacoes' => $faker->text(230),
            'status_id' => '12',
        ]);


        $diligencia->servicos()->attach(1);
        $diligencia->servicos()->attach(2);

        $diligencia1->servicos()->attach(1);

        $diligencia2->servicos()->attach(2);

        $diligencia3->servicos()->attach(2);
        $diligencia3->servicos()->attach(3);

        $diligencia4->servicos()->attach(1);

        $diligencia5->servicos()->attach(4);

        $diligencia7->servicos()->attach(4);

        $diligencia6->servicos()->attach(4);

    }
}
