<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Elaboração Material Técnico',
            'Em Contratação',
            'Em Execução',
            'Finalizado',
            'Suspenso',
        ];

        foreach ($data as $status) {
            Estado::create(['valor' => $status]);
        }
    }
}
