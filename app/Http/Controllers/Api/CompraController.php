<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompraRequest;
use App\Models\Ciudad;
use App\Models\Compra;
use Illuminate\Http\Request;
use Throwable;

class CompraController extends Controller
{

    public function index(Request $request)
    {
        try {
            //
            $ciudad = Ciudad::where('nombres', $request->input('ciudad'))
                ->first();

            //debemos verificar si la ciudad existe en la base de datos por seguridad y estabilidad del sistema
            if ($ciudad == null) {
                return response()->json([
                    'records' => null,
                    'status' => false,
                    'message' => "No se encontro la ciudad de {$request->input('ciudad')}",
                ], 404);
            }

            $compra = Compra::join('ciudades', 'ciudades.id', '=', 'compras.id_ciudad')
                ->select(
                    'compras.*',
                )
                ->where('compras.status', true)
                ->where('ciudades.id', $ciudad->id)
                ->get();

            return response()->json([
                'records' => $compra,
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


    public function store(CompraRequest $request)
    {
        //
    }


    public function update(CompraRequest $request)
    {
        //
    }

    public function destroy(Request $request)
    {
        
    }
}//class
