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
           'level' => '5',
           'phone' => '12341332'
        ]);
    }
}
