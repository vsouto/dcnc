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
        ]);
        $correspondente2 = \App\Correspondente::create([
            'nome' => $faker->name,
        ]);
        $correspondente3 = \App\Correspondente::create([
            'nome' => $faker->name,
        ]);
        $correspondente4 = \App\Correspondente::create([
            'nome' => $faker->name,
            'rating' => '4',
            'atrasos' => '2'
        ]);
        $correspondente5 = \App\Correspondente::create([
            'nome' => $faker->name,
            'atrasos' => '3'
        ]);
        $correspondente6 = \App\Correspondente::create([
            'nome' => $faker->name,
            'atrasos' => '1'
        ]);
        $correspondente7 = \App\Correspondente::create([
            'nome' => $faker->name,
        ]);

        $correspondente1->servicos()->attach(1,['valor' => '55', 'comarca_id' => '1']);
        $correspondente1->servicos()->attach(2,['valor' => '40', 'comarca_id' => '2']);

        $correspondente2->servicos()->attach(1,['valor' => '15', 'comarca_id' => '1']);

        $correspondente4->servicos()->attach(1,['valor' => '30', 'comarca_id' => '2']);
        $correspondente4->servicos()->attach(2,['valor' => '40', 'comarca_id' => '3']);

        $correspondente5->servicos()->attach(1,['valor' => '35', 'comarca_id' => '4']);
        $correspondente5->servicos()->attach(2,['valor' => '55', 'comarca_id' => '5']);

        $correspondente6->servicos()->attach(3,['valor' => '105', 'comarca_id' => '5']);

        $correspondente7->servicos()->attach(4,['valor' => '175', 'comarca_id' => '6']);

        $correspondente1->comarcas()->attach(1);
        $correspondente2->comarcas()->attach(2);
        $correspondente3->comarcas()->attach(3);
        $correspondente4->comarcas()->attach(3);
        $correspondente5->comarcas()->attach(4);
    }
}
