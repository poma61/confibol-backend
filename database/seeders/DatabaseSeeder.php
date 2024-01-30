<?php

namespace Database\Seeders;


use App\Models\Ciudad;
use App\Models\Deposito;
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
            ['nombre_ciudad' => 'La-Paz'],
            ['nombre_ciudad' => 'Santa-Cruz'],
            ['nombre_ciudad' => 'Chuquisaca'],
            ['nombre_ciudad' => 'Cochabamba'],
            ['nombre_ciudad' => 'Potosi'],
            ['nombre_ciudad' => 'Beni'],
            ['nombre_ciudad' => 'Pando'],
            ['nombre_ciudad' => 'Tarija'],
            ['nombre_ciudad' => 'Oruro'],
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
            'nombre_deposito' => 'Deposito 1',
            'direccion' => 'La Paz',
            'id_ciudad' => 1,
            'status' => true,
        ]);

        for ($i = 1; $i <=200; $i++) {
            $__productos[] = [
                'nombre_producto' => 'Mermelada '.$i,
                'marca' => 'Nestle',
                'image_path' => '/storage/img/producto/mermelada.jpeg',
                'categoria' => 'Pasteleria',
                'status' => true,
            ];
        }
        Producto::insert($__productos);
    } //run
} //class
