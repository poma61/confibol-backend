<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductoRequest;
use App\Models\Producto;
use Illuminate\Http\Request;
use Throwable;

class ProductoController extends Controller
{

    public function index()
    {
        try {
            $producto = Producto::where('status', true)
            ->get();
            return response()->json([
                'records' => $producto,
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

    public function store(ProductoRequest $request)
    {
        try {
            $producto = new Producto($request->all());
            $producto->status = true;
            $producto->save();

            return response()->json([
                'record' => $producto,
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


    public function update(ProductoRequest $request)
    {
        try {

            $producto = Producto::where('status', true)
                ->where('id', $request->input('id'))
                ->first();

            if ($producto == null) {
                return response()->json([
                    'record' => null,
                    'status' => false,
                    'message' => "Este registro no se encuentra en el sistema!",
                ], 404);
            }

            $producto->update($request->all());

            return response()->json([
                'record' => $producto,
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
            $producto = Producto::where('status', true)
                ->where('id', $request->input('id'))
                ->first();
            if ($producto == null) {
                return response()->json([
                    'status' => false,
                    'message' => "Este registro no se encuentra en el sistema!",
                ], 404);
            }
            $producto->status = false;
            $producto->update();

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



