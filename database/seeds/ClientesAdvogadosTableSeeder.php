<?php

use Illuminate\Database\Seeder;

class ClientesAdvogadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $bradesco = \App\Cliente::create([
            'nome' => 'Bradesco Seguros',
            'email' => 'bradesco@bradesco.com.br',
            'endereco' => 'Av Raja Gabaglia 112',
            'phone' => '31 1726312',
            'user_id' => '1' // owner
        ]);

        $am = \App\Cliente::create([
            'nome' => 'Andre Mansur Advogados',
            'email' => 'andre@mansur.com.br',
            'endereco' => 'Av Raja Gabaglia 55',
            'phone' => '31 222222',
            'user_id' => '2' // owner
        ]);

        $mndm = \App\Cliente::create([
            'nome' => 'MNDM Advogados',
            'email' => 'bradesco@bradesco.com.br',
            'endereco' => 'Av Raja Gabaglia 112',
            'phone' => '31 4444444',
            'user_id' => '3' // owner
        ]);

        $microsoft  = \App\Cliente::create([
            'nome' => 'Microsoft Brasil',
            'email' => 'micro@microsoft.com.br',
            'endereco' => 'Av Raja Gabaglia 112',
            'phone' => '31 666666',
            'user_id' => '4' // owner
        ]);

        $faker = Faker\Factory::create();

        /**
         * Advogados
         */
        $adv1 = \App\User::create([
            'nome' => 'Joaquim Corleone',
            'email' => 'joaquim@bradesco.com.br',
            'password' => Hash::make('12345'),
            'endereco' => 'Rua ali do lado 123',
            'phone' => '123123',
            'cliente_id' => $bradesco->id,
            'level' => 2
        ]);
        $adv1 = \App\User::create([
            'nome' => 'Pedro Teixeira',
            'email' => $faker->email,
            'password' => Hash::make('12345'),
            'endereco' => $faker->address,
            'phone' => $faker->phoneNumber,
            'cliente_id' => $am->id,
            'level' => 2
        ]);
        $adv1 = \App\User::create([
            'nome' => 'Diostenes Sargueras',
            'email' => $faker->email,
            'password' => Hash::make('12345'),
            'endereco' => $faker->address,
            'phone' => $faker->phoneNumber,
            'cliente_id' => $microsoft->id,
            'level' => 2
        ]);
        $adv1 = \App\User::create([
            'nome' => 'Advogado Costa Silva',
            'email' => $faker->email,
            'password' => Hash::make('12345'),
            'endereco' => $faker->address,
            'phone' => $faker->phoneNumber,
            'cliente_id' => $microsoft->id,
            'level' => 2
        ]);
    }
}
