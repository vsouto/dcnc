<?php

use Illuminate\Database\Seeder;

class ServicosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Servico::create([
            'servico' => 'Preposto',
            'ideal' => '25',
            'max' => '35',
        ]);

        \App\Servico::create([
            'servico' => 'Advogado',
            'ideal' => '50',
            'max' => '60',
        ]);

        \App\Servico::create([
            'servico' => 'Advogado + Preposto',
            'ideal' => '80',
            'max' => '90',
        ]);

        \App\Servico::create([
            'servico' => 'Diligência',
            'ideal' => '24',
            'max' => '30',
        ]);

    }
}
