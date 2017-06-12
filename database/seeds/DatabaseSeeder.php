<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(TiposTableSeeder::class);
        //$this->call(ComarcasTableSeeder::class);
        //$this->call(CorrespondentesTableSeeder::class);
        //$this->call(ClientesAdvogadosTableSeeder::class);
        //$this->call(ServicosTableSeeder::class);
        //$this->call(UsersTableSeeder::class);
        //$this->call(StatusesTableSeeder::class);
        $this->call(DiligenciasTableSeeder::class);
    }
}
