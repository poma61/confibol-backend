<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//add
use App\Http\Requests\UsuarioByUsuHasRoleRequest;
use App\Models\Role;
use App\Models\Ciudad;
use App\Models\Usuario;
use App\Models\UsuarioHasRole;
use Illuminate\Support\Facades\Hash;
use Throwable;


class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        try {
            $ciudad = Ciudad::where('nombre_ciudad', $request->input('ciudad'))
                ->first();
            //debemos verificar si la ciudad existe en la base de datos por seguridad y estabilidad del sistema
            if ($ciudad == null) {
                return response()->json([
                    'records' => null,
                    'status' => false,
                    'message' => "No se encontro la ciudad de {$request->input('ciudad')}!",
                ], 404);
            }

            $user = Usuario::join('usuarios_has_roles', 'usuarios_has_roles.id_user', '=', 'usuarios.id')
                ->join('roles', 'roles.id', '=', 'usuarios_has_roles.id_role')
                ->join('personals', 'personals.id', '=', 'usuarios.id_personal')
                ->join('ciudades', 'ciudades.id', '=', 'personals.id_ciudad')
                ->select(
                    'usuarios.*',
                    'roles.rol_name',
                    'usuarios_has_roles.id_role',
                    'personals.nombres',
                    'personals.apellido_paterno',
                    'personals.apellido_materno',
                    'personals.foto_image_path',
                )
                ->where('personals.status', true)
                ->where('usuarios.user', '<>', 'system')
                ->where('usuarios.status', true)
                ->where('usuarios_has_roles.status', true)
                ->where('ciudades.id', $ciudad->id)
                ->get();

            return response()->json([
                'records' => $user,
                'status' => true,
                'message' => 'OK',
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'records' => null,
                'status' => true,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function store(UsuarioByUsuHasRoleRequest $request)
    {
        try {
            $ciudad = Ciudad::where('nombre_ciudad', $request->input('ciudad'))
                ->exists();
            //debemos verificar si la ciudad existe en la base de datos por seguridad y estabilidad del sistema
            if (!$ciudad) {
                return response()->json([
                    'status' => false,
                    'message' => "No se encontro la ciudad de {$request->input('ciudad')}!",
                ], 404);
            }

            $role = Role::where('id', $request->input('id_role'))
                ->exists();
            //  verificar si el rol existe por seguridad y estabilidad del sistema
            if (!$role) {
                return response()->json([
                    'status' => false,
                    'message' => "No se encontro el rol con id {$request->input('id_role')}!",
                ], 404);
            }

            $usuario = new Usuario();
            $usuario->user = $request->input('user');
            $usuario->password = Hash::make($request->input('password'));
            $usuario->status = true;
            $usuario->id_personal = $request->input('id_personal');
            $usuario->save();

            //creamos el rol 
            $usuario_has_role = new UsuarioHasRole();
            $usuario_has_role->id_role = $request->input('id_role');
            $usuario_has_role->id_user = $usuario->id;
            $usuario_has_role->status = true;
            $usuario_has_role->save();

            $user = Usuario::join('usuarios_has_roles', 'usuarios_has_roles.id_user', '=', 'usuarios.id')
                ->join('roles', 'roles.id', '=', 'usuarios_has_roles.id_role')
                ->join('personals', 'personals.id', '=', 'usuarios.id_personal')
                ->join('ciudades', 'ciudades.id', '=', 'personals.id_ciudad')
                ->select(
                    'usuarios.*',
                    'roles.rol_name',
                    'usuarios_has_roles.id_role',
                    'personals.nombres',
                    'personals.apellido_paterno',
                    'personals.apellido_materno',
                    'personals.foto_image_path',
                ) // no es necesario verificar los status de las tablas porque se supone que es un registro nuevo por lo tanto ya anteriormente se verifico que el registro tiene un status true
                ->where('usuarios.id', $usuario->id)
                ->first();

            return response()->json([
                'record' => $user,
                'status' => true,
                'message' => 'Registro creado!',
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'record' => null,
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function update(UsuarioByUsuHasRoleRequest $request)
    {
        try {
            $ciudad = Ciudad::where('nombre_ciudad', $request->input('ciudad'))
                ->exists();
            //debemos verificar si la ciudad existe en la base de datos por seguridad y estabilidad del sistema
            if (!$ciudad) {
                return response()->json([
                    'status' => false,
                    'message' => "No se encontro la ciudad de {$request->input('ciudad')}!",
                ], 404);
            }

            $role = Role::where('id', $request->input('id_role'))
                ->exists();
            //  verificar si el rol existe por seguridad y estabilidad del sistema
            if (!$role) {
                return response()->json([
                    'status' => false,
                    'message' => "No se encontro el rol con id {$request->input('id_role')}!",
                ], 404);
            }

            $usuario = Usuario::where('status', true)
                ->where('id', $request->input('id'))
                ->first();


            //verificamos si el registro se encuentra por estabilidad del sistema
            if ($usuario == null) {
                return response()->json([
                    'record' => null,
                    'status' => false,
                    'message' => 'Este registro no se encuentra en el sistema!',
                ], 404);
            }

            $usuario->user = $request->input('user');
            $usuario->id_personal = $request->input('id_personal');

            //Si el campo password  NO esta vacio entonces empty devolvera false y se encriptara la contraseña
            if (empty($request->input('password')) == false) {
                $usuario->password = Hash::make($request->input('password'));
            }
            $usuario->update();


            //actualizamos el rol 
            $usuario_has_role = UsuarioHasRole::where('status', true)
                ->where('id_user', $usuario->id)
                ->first();
            $usuario_has_role->id_role = $request->input('id_role');
            $usuario_has_role->update();

            $user = Usuario::join('usuarios_has_roles', 'usuarios_has_roles.id_user', '=', 'usuarios.id')
                ->join('roles', 'roles.id', '=', 'usuarios_has_roles.id_role')
                ->join('personals', 'personals.id', '=', 'usuarios.id_personal')
                ->join('ciudades', 'ciudades.id', '=', 'personals.id_ciudad')
                ->select(
                    'usuarios.*',
                    'roles.rol_name',
                    'usuarios_has_roles.id_role',
                    'personals.nombres',
                    'personals.apellido_paterno',
                    'personals.apellido_materno',
                    'personals.foto_image_path',
                ) // no es necesario verificar los status de las tablas porque se supone que es un registro editato y ya se veririco el status anteriormente segun el codigo
                ->where('usuarios.id', $usuario->id)
                ->first();


            return response()->json([
                'record' => $user,
                'status' => true,
                'message' => 'Registro actualizado!',
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'record' => null,
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }


    public function destroy(Request $request)
    {
        try {
            $usuario = Usuario::where('status', true)
                ->where('id', $request->input('id'))
                ->first();

            //verificamos si el registro se encuentra por estabilidad del sistema
            if ($usuario == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Este registro no se encuentra en el sistema!',
                ], 404);
            }

            //eliminamos el usuario
            $usuario->status = false;
            $usuario->update();

            //eliminamos el role 
            $usuario_has_role = UsuarioHasRole::where('id_user', $usuario->id)
                ->first();
            $usuario_has_role->status = false;
            $usuario_has_role->update();

            return response()->json([
                'status' => true,
                'message' => 'Registro eliminado!',
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
} //class

