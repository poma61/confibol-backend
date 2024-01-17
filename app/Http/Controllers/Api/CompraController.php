<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompraRequest;
use App\Models\Ciudad;
use App\Models\Compra;
use App\Models\ProductoLote;
use Illuminate\Http\Request;
use Throwable;

class CompraController extends Controller
{

    public function indexCompra(Request $request)
    {
        try {
            $ciudad = Ciudad::where('nombres', $request->input('ciudad'))
                ->first();

            //debemos verificar si la ciudad existe en la base de datos por seguridad y estabilidad del sistema
            if ($ciudad == null) {
                return response()->json([
                    'records' => null,
                    'status' => false,
                    'message' => "No se encontro la ciudad de {$request->input('ciudad')}!",
                ], 404);
            }

            $compra = Compra::join('ciudades', 'ciudades.id', '=', 'compras.id_ciudad')
                ->join('documentos_compras', 'documentos_compras.id_compra', '=', 'compras.id')
                ->select(
                    'compras.*',
                )
                ->where('compras.status', true)
                ->where('tipo_compra', $request->input('tipo_compra'))
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
    } //indexCompra

    public function indexCompraProducto(Request $request)
    {
        try {
            $ciudad = Ciudad::where('nombres', $request->input('ciudad'))
                ->first();

            //debemos verificar si la ciudad existe en la base de datos por seguridad y estabilidad del sistema
            if ($ciudad == null) {
                return response()->json([
                    'records' => null,
                    'status' => false,
                    'message' => "No se encontro la ciudad de {$request->input('ciudad')}!",
                ], 404);
            }

            $compra = ProductoLote::join('productos', 'productos.id', '=', 'producto_lotes.id_producto')
                ->select(
                    'producto_lotes.*',
                    'productos.nombres',
                )
                ->where('status', true)
                ->where('id_compra', $request->input('id_compra'))
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
    } //indexCompra


    public function store(CompraRequest $request)
    {
        try {
            $ciudad = Ciudad::where('nombres', $request->input('ciudad'))
                ->first();

            //debemos verificar si la ciudad existe en la base de datos por seguridad y estabilidad del sistema
            if ($ciudad == null) {
                return response()->json([
                    'status' => false,
                    'message' => "No se encontro la ciudad de {$request->input('ciudad')}!",
                ], 404);
            }

            //agregamos la compra realizada
            $compra = new Compra($request->input('compra'));
            $compra->status = true;
            $compra->id_ciudad = $ciudad->id;
            $compra->save();

            //agregamos la lista de productos
            $productos = $request->input('producto_lotes');
            foreach ($productos as $item_producto) {
                $producto = new ProductoLote($item_producto);
                $producto->status = true;
                $producto->id_compra = $compra->id;
                $producto->save();
            }

            return response()->json([
                'record' => $compra,
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

    public function update(CompraRequest $request)
    {
        try {
            $ciudad = Ciudad::where('nombres', $request->input('ciudad'))
                ->first();

            //debemos verificar si la ciudad existe en la base de datos por seguridad y estabilidad del sistema
            if ($ciudad == null) {
                return response()->json([
                    'status' => false,
                    'message' => "No se encontro la ciudad de {$request->input('ciudad')}!",
                ], 404);
            }

            $compra = Compra::where('status', true)
                ->where('id', $request->input('id'))
                ->first();
            if ($compra == null) {
                return response()->json([
                    'record' => null,
                    'status' => false,
                    'message' => "Este registro no se encuentra en el sistema!",
                ], 404);
            }

            $compra->update($request->all());

            return response()->json([
                'record' => $compra,
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
            $ciudad = Ciudad::where('nombres', $request->input('ciudad'))
                ->first();

            //debemos verificar si la ciudad existe en la base de datos por seguridad y estabilidad del sistema
            if ($ciudad == null) {
                return response()->json([
                    'status' => false,
                    'message' => "No se encontro la ciudad de {$request->input('ciudad')}!",
                ], 404);
            }

            $compra = Compra::where('status', true)
                ->where('id', $request->input('id'))
                ->first();
            if ($compra == null) {
                return response()->json([
                    'status' => false,
                    'message' => "Este registro no se encuentra en el sistema!",
                ], 404);
            }

            $compra->status = false;
            $compra->update();

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
}//class
