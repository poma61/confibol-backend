<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//add
use App\Http\Requests\GrupoRequest;
use App\Models\Ciudad;
use App\Models\Grupo;
use Throwable;

class GrupoController extends Controller
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

            $grupo = Grupo::join('ciudades', 'ciudades.id', '=', 'grupos.id_ciudad')
                ->select(
                    'grupos.*',
                )
                ->where('grupos.status', true)
                ->where('ciudades.id', $ciudad->id)
                ->get();

            return response()->json([
                'records' => $grupo,
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

    public function list(Request $request)
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

            $grupo = Grupo::join('ciudades', 'ciudades.id', '=', 'grupos.id_ciudad')
                ->select(
                    'grupos.id',
                    'grupos.nombre_grupo',
                )
                ->where('grupos.status', true)
                ->where('ciudades.id', $ciudad->id)
                ->orderBy('grupos.id', 'desc')
                ->get();

            return response()->json([
                'records' => $grupo,
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

    public function store(GrupoRequest $request)
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

            $grupo = new Grupo($request->all());
            $grupo->status = true;
            $grupo->id_ciudad = $ciudad->id;
            $grupo->save();

            return response()->json([
                'record' => $grupo,
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


    public function update(GrupoRequest $request)
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

            $grupo = Grupo::where('status', true)
                ->where('id', $request->input('id'))
                ->first();
            if ($grupo == null) {
                return response()->json([
                    'record' => null,
                    'status' => false,
                    'message' => "Este registro no se encuentra en el sistema!",
                ], 404);
            }

            $grupo->update($request->all());

            return response()->json([
                'record' => $grupo,
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
            $grupo = Grupo::where('status', true)
                ->where('id', $request->input('id'))
                ->first();
            if ($grupo == null) {
                return response()->json([
                    'status' => false,
                    'message' => "Este registro no se encuentra en el sistema!",
                ], 404);
            }
            $grupo->status = false;
            $grupo->update();

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

