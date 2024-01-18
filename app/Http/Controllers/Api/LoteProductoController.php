<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
//add
use App\Models\ProductoLote;
use Illuminate\Http\Request;
use Throwable;
use App\Http\Requests\LoteProductoRequest;


class LoteProductoController extends Controller
{
    public function index(Request $request)
    {
        try {

            $producto_lote = ProductoLote::where('status', true)
                ->where('id_compra', $request->input("id_compra"))
                ->get();

            return response()->json([
                'records' => $producto_lote,
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
    } //index

    public function store(LoteProductoRequest $request)
    {
        try {

            //agregamos la producto_lote realizada
            $producto_lote = new ProductoLote($request->all());
            $producto_lote->status = true;
            $producto_lote->save();

            return response()->json([
                'record' => $producto_lote,
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

    public function update(LoteProductoRequest $request)
    {
        try {
            $producto_lote = ProductoLote::where('status', true)
                ->where('id', $request->input('id'))
                ->first();

            //verificamos si el registro existe por estabilidad del sistema
            if ($producto_lote == null) {
                return response()->json([
                    'record' => null,
                    'status' => false,
                    'message' => "Este registro no se encuentra en el sistema!",
                ], 404);
            }

            $producto_lote->update($request->all());

            return response()->json([
                'record' => $producto_lote,
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
            $producto_lote = ProductoLote::where('status', true)
                ->where('id', $request->input('id'))
                ->first();

            //verificamos si el registro existe por estabilidad del sistema
            if ($producto_lote == null) {
                return response()->json([
                    'record' => null,
                    'status' => false,
                    'message' => "Este registro no se encuentra en el sistema!",
                ], 404);
            }

            $producto_lote->status = false;
            $producto_lote->update();

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
