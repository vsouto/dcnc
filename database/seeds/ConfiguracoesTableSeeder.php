<?php

use Illuminate\Database\Seeder;

class ConfiguracoesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $config = \App\Configuracoes::create([
            'chave' => 'Atraso_Diligencia',
            'descricao' => 'Tempo a ser esperado após o prazo, para poder considerar uma diligência como atrasada.',
            'valor' => '8'
        ]);

        $config = \App\Configuracoes::create([
            'chave' => 'Aceitacao_Correspondente',
            'descricao' => 'Tempo limite para que o Correspondente aceite a execução da Diligência',
            'valor' => '8'
        ]);

        $config = \App\Configuracoes::create([
            'chave' => 'Checkin_Correspondente',
            'descricao' => 'Tempo antes do prazo que fará o sistema cobrar o Checkin do Correspondente.',
            'valor' => '48'
        ]);

        $config = \App\Configuracoes::create([
            'chave' => 'Sem_Checkin_Correspondente',
            'descricao' => 'Tempo limite após a cobrança do Checkin para que o Correspondente faça checkin. Após esse limite'
                .' a diligência mudará status para SEM CHECKIN',
            'valor' => '32'
        ]);
    }
}
