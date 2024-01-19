<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Throwable;

class ProductoController extends Controller
{

    public function index()
    {
        try {
            $producto = Producto::join("categorias", "categorias.id", "=", "productos.id_categoria")
                ->select(
                    "productos.*",
                    "catagorias.nombres as categoria",
                )
                ->where('categorias.status', true)
                ->where('prdocutos.status', true)
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


    public function list()
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


    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


} //class
