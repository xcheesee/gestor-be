<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds:
     *
     * php artisan db:seed --class=CategoriaSeeder
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Obra',
            'Serviço',
            'Aquisição',
        ];

        $id = 1;
        foreach ($data as $categoria) {
             Categoria::create(['id' => $id, 'nome' => $categoria]);
             $id++;
        }
    }
}
