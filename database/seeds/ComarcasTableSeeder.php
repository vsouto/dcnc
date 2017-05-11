<?php

use Illuminate\Database\Seeder;

class ComarcasTableSeeder extends Seeder
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

        $comarca = \App\Comarca::create([
            'comarca' => 'Acrelândia'
        ]);
        $comarca = \App\Comarca::create([
            'comarca' => 'Rio de Janeiro'
        ]);
        $comarca = \App\Comarca::create([
            'comarca' => 'Belo Horizonte'
        ]);
        $comarca = \App\Comarca::create([
            'comarca' => 'Macapá'
        ]);
        $comarca = \App\Comarca::create([
            'comarca' => 'Sena Madureira'
        ]);
    }
}
