<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClienteRequest;
use Illuminate\Http\Request;
//add
use App\Models\Ciudad;
use App\Models\Cliente;
use App\Models\Grupo;
use Throwable;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        try {
            $ciudad = Ciudad::where('nombre_ciudad', $request->input('ciudad'))
                ->first();

            //debemos verificar si la ciudad existe en la base de datos por seguridad y estabilidad del sistema
            if ($ciudad == null) {
                return response()->json([
                    'status' => false,
                    'message' => "No se encontro la ciudad de {$request->input('ciudad')}!",
                ], 404);
            }

            $cliente = Cliente::join('grupos', 'grupos.id', '=', 'clientes.id_grupo')
                ->join('ciudades', 'ciudades.id', '=', 'grupos.id_ciudad')
                ->select(
                    'clientes.*',
                )
                ->where('clientes.status', true)
                ->where('grupos.status', true)
                ->where('ciudades.id', $ciudad->id)
                ->get();

            return response()->json([
                'records' => $cliente,
                'status' => true,
                'message' => "OK",
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'records' => null,
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function store(ClienteRequest $request)
    {
        try {
            $ciudad = Ciudad::where('nombre_ciudad', $request->input('ciudad'))
                ->exists();

            $grupo = Grupo::where('status', true)
                ->where('id', $request->input('id_grupo'))
                ->exists();
            //debemos verificar si la ciudad y grupo existe en la base de datos por seguridad y estabilidad del sistema
            //si NO verificamos la ciudad no afecta en nada al registrar el registro, pero igual lo hacemos por buenas practicas de programacion
            //si NO verificamos el grupo SI afecta al crear el registro, porque desde el frontend viene en el $request  el "id_grupo" y este es un campo
            //para crear un registro nuevo. Por lo tanto se debe verificar si existe o no el grupo en cuestion.
            if (!$ciudad || !$grupo) {
                return response()->json([
                    'status' => false,
                    'message' => "No se encontro la ciudad de {$request->input('ciudad')} y/o no existe el grupo con id {$request->input('id_grupo')}!",
                ], 404);
            }

            $cliente = new Cliente($request->all());
            $cliente->status = true;
            $cliente->save();

            return response()->json([
                'record' => $cliente,
                'status' => true,
                'message' => "Registro guardado!",
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'record' => null,
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function update(ClienteRequest $request)
    {
        try {
            $ciudad = Ciudad::where('nombre_ciudad', $request->input('ciudad'))
                ->exists();

            $grupo = Grupo::where('status', true)
                ->where('id', $request->input('id_grupo'))
                ->exists();
            //debemos verificar si la ciudad y grupo existe en la base de datos por seguridad y estabilidad del sistema
            //si NO verificamos la ciudad no afecta en nada al registrar el registro, pero igual lo hacemos por buenas practicas de programacion
            //si NO verificamos el grupo SI afecta al crear el registro, porque desde el frontend viene en el $request  el "id_grupo" y este es un campo
            //para modificar un registro. Por lo tanto se debe verificar si existe o no el grupo en cuestion.
            if (!$ciudad || !$grupo) {
                return response()->json([
                    'status' => false,
                    'message' => "No se encontro la ciudad de {$request->input('ciudad')} y/o no existe el grupo con id {$request->input('id_grupo')}!",
                ], 404);
            }

            $cliente = Cliente::where('status', true)
                ->where('id', $request->input('id'))
                ->first();
            if ($cliente == null) {
                return response()->json([
                    'record' => null,
                    'status' => false,
                    'message' => "Este registro no se encuentra en el sistema!",
                ], 404);
            }

            $cliente->update($request->all());

            return response()->json([
                'record' => $cliente,
                'status' => true,
                'message' => "Registro actualizado!",
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
            $cliente = Cliente::where('status', true)
                ->where('id', $request->input('id'))
                ->first();
            if ($cliente == null) {
                return response()->json([
                    'status' => false,
                    'message' => "Este registro no se encuentra en el sistema!",
                ], 404);
            }

            $cliente->status = false;
            $cliente->update();

            return response()->json([
                'status' => true,
                'message' => "Registro eliminado!",
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
} //class