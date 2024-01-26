<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
//add
use App\Http\Requests\DepositoRequest;
use App\Models\Ciudad;
use App\Models\Deposito;
use Illuminate\Http\Request;
use Throwable;

class DepositoController extends Controller
{

    public function index(Request $request)
    {
        try {
            $ciudad = Ciudad::where('nombres', $request->input('ciudad'))
                ->first();

            //debemos verificar si la ciudad existe en la base de datos por seguridad y estabilidad del sistema
            if ($ciudad == null) {
                return response()->json([
                    'status' => false,
                    'message' => "No se encontro la ciudad de {$request->input('ciudad')}",
                ], 404);
            }

            $deposito = Deposito::join('ciudades', 'ciudades.id', '=', 'depositos.id_ciudad')
                ->select(
                    'depositos.*',
                )
                ->where('depositos.status', true)
                ->where('ciudades.id', $ciudad->id)
                ->get();

            return response()->json([
                'records' => $deposito,
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

    public function list()
    {
        try {
            $deposito = Deposito::join('ciudades', 'ciudades.id', '=', 'depositos.id_ciudad')
                ->select(
                    'depositos.id',
                    'depositos.nombre_deposito as deposito',
                    'ciudades.nombres as ciudad',
                )
                ->where('depositos.status', true)

                ->get();

            return response()->json([
                'records' => $deposito,
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


    public function store(DepositoRequest $request)
    {
        try {
            $ciudad = Ciudad::where('nombres', $request->input('ciudad'))
                ->first();

            //debemos verificar si la ciudad existe en la base de datos por seguridad y estabilidad del sistema
            if ($ciudad == null) {
                return response()->json([
                    'status' => false,
                    'message' => "No se encontro la ciudad de {$request->input('ciudad')}",
                ], 404);
            }

            $deposito = new Deposito($request->all());
            $deposito->status = true;
            $deposito->id_ciudad = $ciudad->id;
            $deposito->save();

            return response()->json([
                'record' => $deposito,
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


    public function update(DepositoRequest $request)
    {
        try {

            $deposito = Deposito::where('status', true)
                ->where('id', $request->input('id'))
                ->first();
            if ($deposito == null) {
                return response()->json([
                    'record' => null,
                    'status' => false,
                    'message' => "Este registro no se encuentra en el sistema!",
                ], 404);
            }

            $deposito->update($request->all());

            return response()->json([
                'record' => $deposito,
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

            $deposito = Deposito::where('status', true)
                ->where('id', $request->input('id'))
                ->first();
            if ($deposito == null) {
                return response()->json([
                    'status' => false,
                    'message' => "Este registro no se encuentra en el sistema!",
                ], 404);
            }

            $deposito->status = false;
            $deposito->update();

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
