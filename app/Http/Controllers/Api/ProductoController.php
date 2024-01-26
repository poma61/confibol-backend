<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductoRequest;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            $producto = new Producto($request->except(['image_file', 'image_path']));
            $image_path = $request->file('image_file')->store('img/producto', 'public');
            $producto->image_path = "/storage/{$image_path}";
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

            $producto->fill($request->except(['image_file', 'image_path']));
            //verificar si subio una nueva imagen
            if ($request->file('image_file') != null) {
                //eliminamos antigua foto 
                Storage::disk('public')->delete(str_replace("/storage", "", $producto->image_path));
                $image_path = $request->file('image_file')->store('img/producto', 'public');
                $producto->image_path = "/storage/{$image_path}";
            }
            $producto->update();

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



