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
            'email' => $faker->email,
            'comarca_id' => '1'
        ]);
        $correspondente2 = \App\Correspondente::create([
            'nome' => $faker->name,
            'email' => $faker->email,
            'comarca_id' => '2'
        ]);
        $correspondente3 = \App\Correspondente::create([
            'nome' => $faker->name,
            'email' => $faker->email,
            'comarca_id' => '3'
        ]);
        $correspondente4 = \App\Correspondente::create([
            'nome' => $faker->name,
            'email' => $faker->email,
            'comarca_id' => '4'
        ]);

        $correspondente1->servicos()->attach(1,['valor' => '55', 'max' => '70']);
        $correspondente1->servicos()->attach(2,['valor' => '40', 'max' => '95']);

        $correspondente2->servicos()->attach(1,['valor' => '30', 'max' => '50']);

        $correspondente3->servicos()->attach(3,['valor' => '60', 'max' => '80']);
        $correspondente3->servicos()->attach(4,['valor' => '50', 'max' => '120']);

        $correspondente4->servicos()->attach(1,['valor' => '30', 'max' => '50']);
        $correspondente4->servicos()->attach(2,['valor' => '40', 'max' => '60']);
        $correspondente4->servicos()->attach(3,['valor' => '50', 'max' => '130']);
        $correspondente4->servicos()->attach(4,['valor' => '60', 'max' => '390']);
    }
}
