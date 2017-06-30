<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\User::create([
           'nome' => 'Victor Souto',
           'email' => 'souto.victor@gmail.com',
           'password' => Hash::make('12345'),
           'level' => '9',
           'phone' => '12341332'
        ]);

        \App\User::create([
            'nome' => 'Rafael Cinini',
            'email' => 'rafael@gmail.com',
            'password' => Hash::make('12345'),
            'level' => '5',
            'phone' => '12341332'
        ]);

        \App\User::create([
            'nome' => 'Lícia Carvalho',
            'email' => 'licia@gmail.com',
            'password' => Hash::make('12345'),
            'level' => '5',
            'phone' => '12341332'
        ]);

        // Correspondente
        \App\User::create([
            'nome' => 'Correspondente',
            'email' => 'correspondente@gmail.com',
            'password' => Hash::make('12345'),
            'level' => '1',
            'phone' => '12341332',
            'correspondente_id' => '1'
        ]);

        // Correspondente
        \App\User::create([
            'nome' => 'Correspondente 2',
            'email' => 'correspondente2@gmail.com',
            'password' => Hash::make('12345'),
            'level' => '1',
            'phone' => '12341332',
            'correspondente_id' => '2'
        ]);

        // Correspondente
        \App\User::create([
            'nome' => 'Correspondente 3',
            'email' => 'correspondente3@gmail.com',
            'password' => Hash::make('12345'),
            'level' => '1',
            'phone' => '12341332',
            'correspondente_id' => '3'
        ]);


    }
}
