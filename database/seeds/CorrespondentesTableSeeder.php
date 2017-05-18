<?php

use Illuminate\Database\Seeder;

class CorrespondentesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $faker = Faker\Factory::create();

        $correspondente1 = \App\Correspondente::create([
            'nome' => $faker->name,
            'comarca_id' => '1'
        ]);
        $correspondente2 = \App\Correspondente::create([
            'nome' => $faker->name,
            'comarca_id' => '2'
        ]);
        $correspondente3 = \App\Correspondente::create([
            'nome' => $faker->name,
            'comarca_id' => '3'
        ]);
        $correspondente4 = \App\Correspondente::create([
            'nome' => $faker->name,
            'comarca_id' => '4',
            'rating' => '4'
        ]);
        $correspondente5 = \App\Correspondente::create([
            'nome' => $faker->name,
            'comarca_id' => '1'
        ]);
        $correspondente6 = \App\Correspondente::create([
            'nome' => $faker->name,
            'comarca_id' => '2'
        ]);
        $correspondente7 = \App\Correspondente::create([
            'nome' => $faker->name,
            'comarca_id' => '4'
        ]);

        $correspondente1->servicos()->attach(1,['valor' => '55']);
        $correspondente1->servicos()->attach(2,['valor' => '40']);

        $correspondente2->servicos()->attach(1,['valor' => '30']);

        $correspondente3->servicos()->attach(3,['valor' => '60']);
        $correspondente3->servicos()->attach(4,['valor' => '50']);

        $correspondente4->servicos()->attach(1,['valor' => '30']);
        $correspondente4->servicos()->attach(2,['valor' => '40']);
        $correspondente4->servicos()->attach(3,['valor' => '50']);
        $correspondente4->servicos()->attach(4,['valor' => '60']);

        $correspondente5->servicos()->attach(1,['valor' => '35']);
        $correspondente5->servicos()->attach(2,['valor' => '55']);

        $correspondente6->servicos()->attach(3,['valor' => '105']);

        $correspondente7->servicos()->attach(4,['valor' => '175']);
    }
}
