<?php

namespace Database\Seeders;


use App\Models\Personal;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        Personal::create([
            'nombres' => 'Admin',
            'apellido_paterno' => 'ap paterno',
            'apellido_materno' => 'ap materno',
            'cargo' => 'Sin especificar',
            'ci' => 123456,
            'ci_expedido' => 'OR',
            'n_de_contacto' => 1234567,
            'direccion' => 'La Paz - Bolivia',
            'status' => true,
            'foto' => '/storage/img/personal/user.png',
            //  'id_desarrolladora' => 1,
        ]);

        Usuario::create([
            'user' => 'admin',
            'status' => true,
            'password' => '$2y$12$JxmG1vq6EVpT8Bz7k/ArxOZnnaKnsFpNMYV6g7Ck5K.FMyItMOby6', //=> 1234
            'id_personal' => 1,
        ]);

    }
}
