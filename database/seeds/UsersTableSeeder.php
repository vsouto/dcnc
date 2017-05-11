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
            'email' => 'souto.victor2@gmail.com',
            'password' => Hash::make('12345'),
            'level' => '1',
            'phone' => '12341332',
            'correspondente_id' => '1'
        ]);

        // Correspondente
        \App\User::create([
            'nome' => 'Correspondente',
            'email' => 'souto34r2@gmail.com',
            'password' => Hash::make('12345'),
            'level' => '1',
            'phone' => '12341332',
            'correspondente_id' => '2'
        ]);

        // Correspondente
        \App\User::create([
            'nome' => 'Correspondente',
            'email' => 'sou21or2@gmail.com',
            'password' => Hash::make('12345'),
            'level' => '1',
            'phone' => '12341332',
            'correspondente_id' => '3'
        ]);

        // Correspondente
        \App\User::create([
            'nome' => 'Correspondente',
            'email' => 'souawe@gmail.com',
            'password' => Hash::make('12345'),
            'level' => '1',
            'phone' => '12341332',
            'correspondente_id' => '4'
        ]);

    }
}
