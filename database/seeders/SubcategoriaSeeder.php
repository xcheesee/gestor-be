<?php

namespace Database\Seeders;

use App\Models\Subcategoria;
use Illuminate\Database\Seeder;

class SubcategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds:
     *
     * php artisan db:seed --class=SubcategoriaSeeder
     *
     * @return void
     */
    public function run()
    {
        //
        $obra = [
            'Implantação de Parque',
            'Requalificação de Parque',
            'Outro',
        ];

        $servico = [
            'Projeto de Implantação de Parque',
            'Projeto de Requalificação de Parque',
            'Manejo e conservação de Parque',
            'Zeladoria de Parque',
            'Vigilância de Parque',
            'Manejo, Conservação e Zeladoria de Parque',
            'Plantio de árvores',
            'Produção de mudas',
            'Manejo de animais silvestres',
            'Estudos, Planos e Projetos Ambientais',
            'Educação Ambiental',
            'Tecnologia da Informação',
            'Comunicação',
            'Outro',
        ];

        $aquisicao = [
            'Materiais de consumo',
            'Equipamentos e materiais permanentes',
            'Outro',
        ];

        foreach ($obra as $categoria) {
            Subcategoria::create(['categoria_id' => 1,'nome' => $categoria]);
        }

        foreach ($servico as $categoria) {
            Subcategoria::create(['categoria_id' => 2,'nome' => $categoria]);
        }

        foreach ($aquisicao as $categoria) {
            Subcategoria::create(['categoria_id' => 3,'nome' => $categoria]);
        }
    }
}
