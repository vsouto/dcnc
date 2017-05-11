<?php

use Illuminate\Database\Seeder;

class TiposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $tipo = \App\Tipo::create([
            'tipo' => 'Audiência',
            'descricao' => ''
        ]);

        $tipo = \App\Tipo::create([
            'tipo' => 'Audiência só Advogado',
            'descricao' => ''
        ]);

        $tipo = \App\Tipo::create([
            'tipo' => 'Preposto',
            'descricao' => ''
        ]);

        $tipo = \App\Tipo::create([
            'tipo' => 'Extração Cópias',
            'descricao' => ''
        ]);

        $tipo = \App\Tipo::create([
            'tipo' => 'Protoclo',
            'descricao' => ''
        ]);

        $tipo = \App\Tipo::create([
            'tipo' => 'Despacho',
            'descricao' => ''
        ]);
        $tipo = \App\Tipo::create([
            'tipo' => 'Outro',
            'descricao' => ''
        ]);
    }
}
