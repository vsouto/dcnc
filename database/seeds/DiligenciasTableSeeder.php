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
            'prazo' => \Carbon\Carbon::now()->subDays(7),
            'advogado_id' => '1',
            'solicitante' => $faker->name,
            'reu' => $faker->name,
            'num_processo' => $faker->numberBetween(0,999),
            'orgao' => $faker->company,
            'local_orgao' => $faker->address,
            'vara' => $faker->company,
            'orientacoes' => $faker->text(230),
            'comarca_id' => '1',
            'autor' => 'Pedro'
        ]);
        $diligencia2 = \App\Diligencia::create([
            'titulo' => 'Diligência 2',
            'descricao' => 'Entregar a poapeamwea aewaqe',
            'num_integracao' => '332',
            'prazo' => \Carbon\Carbon::now()->addHours(1),
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
            'comarca_id' => '2',
            'autor' => 'Pedro'
        ]);
        $diligencia3 = \App\Diligencia::create([
            'titulo' => 'Contestar Carga',
            'descricao' => $faker->text(90),
            'num_integracao' => $faker->numberBetween(1,999),
            'prazo' => \Carbon\Carbon::now()->addHours(8),
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
            'comarca_id' => '2',
            'autor' => 'Pedro'
        ]);
        $diligencia4 = \App\Diligencia::create([
            'titulo' => 'Contestar Carga',
            'descricao' => $faker->text(90),
            'num_integracao' => $faker->numberBetween(1,999),
            'prazo' => \Carbon\Carbon::now()->addHours(9),
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
            'comarca_id' => '3',
            'autor' => 'Pedro'
        ]);
        $diligencia5 = \App\Diligencia::create([
            'titulo' => 'Contestar Entrega',
            'descricao' => $faker->text(90),
            'num_integracao' => $faker->numberBetween(1,999),
            'prazo' => \Carbon\Carbon::now()->addHours(13),
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
            'comarca_id' => '4',
            'autor' => 'Pedro'
        ]);
        $diligencia6 = \App\Diligencia::create([
            'titulo' => 'Notificação do Consumidor',
            'descricao' => $faker->text(90),
            'num_integracao' => $faker->numberBetween(1,999),
            'prazo' => \Carbon\Carbon::now()->addHours(19),
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
            'comarca_id' => '5',
            'autor' => 'Pedro'
        ]);
        $diligencia7 = \App\Diligencia::create([
            'titulo' => 'Notificação ao Produtor',
            'descricao' => $faker->text(90),
            'num_integracao' => $faker->numberBetween(1,999),
            'prazo' => \Carbon\Carbon::now()->addHours(23),
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
            'comarca_id' => '5',
            'autor' => 'Pedro'
        ]);
        $diligencia = \App\Diligencia::create([
            'titulo' => 'Notificação de Despejo',
            'descricao' => $faker->text(90),
            'num_integracao' => $faker->numberBetween(1,999),
            'prazo' => \Carbon\Carbon::now()->addHours(25),
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
            'comarca_id' => '6',
            'autor' => 'Pedro'
        ]);
        $diligencia = \App\Diligencia::create([
            'titulo' => 'Notificação de Despejo',
            'descricao' => $faker->text(90),
            'num_integracao' => $faker->numberBetween(1,999),
            'prazo' => \Carbon\Carbon::now()->addHours(32),
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
            'comarca_id' => '7',
            'autor' => 'Pedro'
        ]);
        $diligencia = \App\Diligencia::create([
            'titulo' => 'Notificação de Despejo',
            'descricao' => $faker->text(90),
            'num_integracao' => $faker->numberBetween(1,999),
            'prazo' => \Carbon\Carbon::now()->addDays(12),
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
            'autor' => 'Pedro'
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
