<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Ciudad;
use App\Models\Deposito;
use App\Models\Grupo;
use App\Models\Personal;
use App\Models\Producto;
use App\Models\Role;
use App\Models\Usuario;
use App\Models\UsuarioRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        Ciudad::insert([
            ['nombres' => 'La-Paz'],
            ['nombres' => 'Santa-Cruz'],
            ['nombres' => 'Chuquisaca'],
            ['nombres' => 'Cochabamba'],
            ['nombres' => 'Potosi'],
            ['nombres' => 'Beni'],
            ['nombres' => 'Pando'],
            ['nombres' => 'Tarija'],
            ['nombres' => 'Oruro'],
        ]);

        Grupo::insert([
            //Santa-Cruz
            ['number' => '01', 'id_ciudad' => 1, 'descripcion' => '01'],
            ['number' => '02', 'id_ciudad' => 1, 'descripcion' => '02'],
            ['number' => '03', 'id_ciudad' => 1, 'descripcion' => '03'],
            ['number' => '04', 'id_ciudad' => 1, 'descripcion' => '04'],
            ['number' => '05', 'id_ciudad' => 1, 'descripcion' => '05'],
            ['number' => '06', 'id_ciudad' => 1, 'descripcion' => '06'],
            ['number' => '07', 'id_ciudad' => 1, 'descripcion' => '07'],
            ['number' => '08', 'id_ciudad' => 1, 'descripcion' => '08'],
            ['number' => '09', 'id_ciudad' => 1, 'descripcion' => '09'],
            ['number' => '10', 'id_ciudad' => 1, 'descripcion' => '10'],
            //Chuquisaca
            ['number' => '01', 'id_ciudad' => 2, 'descripcion' => '01'],
            ['number' => '02', 'id_ciudad' => 2, 'descripcion' => '02'],
            ['number' => '03', 'id_ciudad' => 2, 'descripcion' => '03'],
            ['number' => '04', 'id_ciudad' => 2, 'descripcion' => '04'],
            ['number' => '05', 'id_ciudad' => 2, 'descripcion' => '05'],
            ['number' => '06', 'id_ciudad' => 2, 'descripcion' => '06'],
            ['number' => '07', 'id_ciudad' => 2, 'descripcion' => '07'],
            ['number' => '08', 'id_ciudad' => 2, 'descripcion' => '08'],
            ['number' => '09', 'id_ciudad' => 2, 'descripcion' => '09'],
            ['number' => '10', 'id_ciudad' => 2, 'descripcion' => '10'],
            //Cochabamba
            ['number' => '01', 'id_ciudad' => 3, 'descripcion' => '01'],
            ['number' => '02', 'id_ciudad' => 3, 'descripcion' => '02'],
            ['number' => '03', 'id_ciudad' => 3, 'descripcion' => '03'],
            ['number' => '04', 'id_ciudad' => 3, 'descripcion' => '04'],
            ['number' => '05', 'id_ciudad' => 3, 'descripcion' => '05'],
            ['number' => '06', 'id_ciudad' => 3, 'descripcion' => '06'],
            ['number' => '07', 'id_ciudad' => 3, 'descripcion' => '07'],
            ['number' => '08', 'id_ciudad' => 3, 'descripcion' => '08'],
            ['number' => '09', 'id_ciudad' => 3, 'descripcion' => '09'],
            ['number' => '10', 'id_ciudad' => 3, 'descripcion' => '10'],
            //Potosi
            ['number' => '01', 'id_ciudad' => 4, 'descripcion' => '01'],
            ['number' => '02', 'id_ciudad' => 4, 'descripcion' => '02'],
            ['number' => '03', 'id_ciudad' => 4, 'descripcion' => '03'],
            ['number' => '04', 'id_ciudad' => 4, 'descripcion' => '04'],
            ['number' => '05', 'id_ciudad' => 4, 'descripcion' => '05'],
            ['number' => '06', 'id_ciudad' => 4, 'descripcion' => '06'],
            ['number' => '07', 'id_ciudad' => 4, 'descripcion' => '07'],
            ['number' => '08', 'id_ciudad' => 4, 'descripcion' => '08'],
            ['number' => '09', 'id_ciudad' => 4, 'descripcion' => '09'],
            ['number' => '10', 'id_ciudad' => 4, 'descripcion' => '10'],
            //Beni
            ['number' => '01', 'id_ciudad' => 5, 'descripcion' => '01'],
            ['number' => '02', 'id_ciudad' => 5, 'descripcion' => '02'],
            ['number' => '03', 'id_ciudad' => 5, 'descripcion' => '03'],
            ['number' => '04', 'id_ciudad' => 5, 'descripcion' => '04'],
            ['number' => '05', 'id_ciudad' => 5, 'descripcion' => '05'],
            ['number' => '06', 'id_ciudad' => 5, 'descripcion' => '06'],
            ['number' => '07', 'id_ciudad' => 5, 'descripcion' => '07'],
            ['number' => '08', 'id_ciudad' => 5, 'descripcion' => '08'],
            ['number' => '09', 'id_ciudad' => 5, 'descripcion' => '09'],
            ['number' => '10', 'id_ciudad' => 5, 'descripcion' => '10'],
            //La-Paz
            ['number' => '01', 'id_ciudad' => 6, 'descripcion' => '01'],
            ['number' => '02', 'id_ciudad' => 6, 'descripcion' => '02'],
            ['number' => '03', 'id_ciudad' => 6, 'descripcion' => '03'],
            ['number' => '04', 'id_ciudad' => 6, 'descripcion' => '04'],
            ['number' => '05', 'id_ciudad' => 6, 'descripcion' => '05'],
            ['number' => '06', 'id_ciudad' => 6, 'descripcion' => '06'],
            ['number' => '07', 'id_ciudad' => 6, 'descripcion' => '07'],
            ['number' => '08', 'id_ciudad' => 6, 'descripcion' => '08'],
            ['number' => '09', 'id_ciudad' => 6, 'descripcion' => '09'],
            ['number' => '10', 'id_ciudad' => 6, 'descripcion' => '10'],
            //Pando
            ['number' => '01', 'id_ciudad' => 7, 'descripcion' => '01'],
            ['number' => '02', 'id_ciudad' => 7, 'descripcion' => '02'],
            ['number' => '03', 'id_ciudad' => 7, 'descripcion' => '03'],
            ['number' => '04', 'id_ciudad' => 7, 'descripcion' => '04'],
            ['number' => '05', 'id_ciudad' => 7, 'descripcion' => '05'],
            ['number' => '06', 'id_ciudad' => 7, 'descripcion' => '06'],
            ['number' => '07', 'id_ciudad' => 7, 'descripcion' => '07'],
            ['number' => '08', 'id_ciudad' => 7, 'descripcion' => '08'],
            ['number' => '09', 'id_ciudad' => 7, 'descripcion' => '09'],
            ['number' => '10', 'id_ciudad' => 7, 'descripcion' => '10'],
            //Tarija
            ['number' => '01', 'id_ciudad' => 8, 'descripcion' => '01'],
            ['number' => '02', 'id_ciudad' => 8, 'descripcion' => '02'],
            ['number' => '03', 'id_ciudad' => 8, 'descripcion' => '03'],
            ['number' => '04', 'id_ciudad' => 8, 'descripcion' => '04'],
            ['number' => '05', 'id_ciudad' => 8, 'descripcion' => '05'],
            ['number' => '06', 'id_ciudad' => 8, 'descripcion' => '06'],
            ['number' => '07', 'id_ciudad' => 8, 'descripcion' => '07'],
            ['number' => '08', 'id_ciudad' => 8, 'descripcion' => '08'],
            ['number' => '09', 'id_ciudad' => 8, 'descripcion' => '09'],
            ['number' => '10', 'id_ciudad' => 8, 'descripcion' => '10'],

            //Oruro
            ['number' => '01', 'id_ciudad' => 9, 'descripcion' => '01'],
            ['number' => '02', 'id_ciudad' => 9, 'descripcion' => '02'],
            ['number' => '03', 'id_ciudad' => 9, 'descripcion' => '03'],
            ['number' => '04', 'id_ciudad' => 9, 'descripcion' => '04'],
            ['number' => '05', 'id_ciudad' => 9, 'descripcion' => '05'],
            ['number' => '06', 'id_ciudad' => 9, 'descripcion' => '06'],
            ['number' => '07', 'id_ciudad' => 9, 'descripcion' => '07'],
            ['number' => '08', 'id_ciudad' => 9, 'descripcion' => '08'],
            ['number' => '09', 'id_ciudad' => 9, 'descripcion' => '09'],
            ['number' => '10', 'id_ciudad' => 9, 'descripcion' => '10'],
        ]);

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
            'id_ciudad' => 1,
        ]);

        Usuario::create([
            'user' => 'admin',
            'status' => true,
            'password' => '$2y$12$JxmG1vq6EVpT8Bz7k/ArxOZnnaKnsFpNMYV6g7Ck5K.FMyItMOby6', //=> 1234
            'id_personal' => 1,
        ]);

        Role::create([
            'rol_name' => 'administrador',
        ]);
        Role::create([
            'rol_name' => 'usuario',
        ]);

        UsuarioRole::create([
            'id_user' => 1,
            'id_role' => 1,
            'status' => true,
        ]);

        //datos de prueba
        Deposito::create([
            'nombres' => 'Deposito 1',
            'direccion' => 'La Paz',
            'id_ciudad' => 1,
            'status' => true,
        ]);
        
        Categoria::create([
            'nombres' => 'Pasteleria',
            'id_ciudad' => 1,
            'status' => true,
        ]);

        Producto::create([
            'nombres' => 'Mermelada',
            'imagen' => 'Caramelo',
            'id_categoria' => 1,
            'status' => true,
        ]);
    } //run
}//class
