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
/*
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
        ]);*/

        //$path = storage_path('app/files/comarcas2.sql');
        $path = public_path('files/comarcas2.sql');

        \Illuminate\Support\Facades\DB::unprepared(file_get_contents($path));

        $this->command->info('Comarcas table seeded!');

    }
}
