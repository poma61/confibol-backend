<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
//add
use App\Models\LoteProducto;
use Illuminate\Http\Request;
use Throwable;
use App\Http\Requests\LoteProductoRequest;
use App\Models\Compra;
use App\Models\Deposito;
use App\Models\DocumentoCompra;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class LoteProductoController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $producto_lote = LoteProducto::join("productos", "productos.id", "=", "lote_productos.id_producto")
                ->join("depositos", "depositos.id", "=", "lote_productos.id_deposito")
                ->join("ciudades", "ciudades.id", "=", "depositos.id_ciudad")
                ->select(
                    "lote_productos.*",
                    "depositos.nombre_deposito",
                    "productos.nombre_producto",
                    "productos.marca",
                    "productos.img_producto",
                    "ciudades.nombres as ciudad",
                )
                ->where('productos.status', true)
                ->where('depositos.status', true)
                ->where('lote_productos.status', true)
                ->where('lote_productos.id_compra', $request->input("id_compra"))
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

    public function store(LoteProductoRequest $request): JsonResponse
    {
        try {
            $__lote_productos = $request->input("lote_productos");

            //verificamos si deposito, producto y compra no estan eliminados
            //por estabilidad del sistemaa
            //el metodo exists() devuelve true si al menos hay un registros 
            foreach ($__lote_productos as $values_lote_producto) {
                $deposito = Deposito::where("status", true)
                    ->where("id", $values_lote_producto['id_deposito'])
                    ->exists();
                if (!$deposito) {
                    return response()->json([
                        'records' => null,
                        'status' => false,
                        'message' => "El deposito con id {$values_lote_producto['id_deposito']} no se encuentra registrado en el sistema!",
                    ], 404);
                }

                $producto = Producto::where("status", true)
                    ->where("id", $values_lote_producto['id_producto'])
                    ->exists();
                if (!$producto) {
                    return response()->json([
                        'records' => null,
                        'status' => false,
                        'message' => "El producto con id {$values_lote_producto['id_producto']} no se encuentra registrado en el sistema!",
                    ], 404);
                }

                $compra = Compra::where("status", true)
                    ->where("id", $values_lote_producto['id_compra'])
                    ->exists();
                if (!$compra) {
                    return response()->json([
                        'records' => null,
                        'status' => false,
                        'message' => "La compra con id {$values_lote_producto['id_compra']} no se encuentra registrado en el sistema!",
                    ], 404);

                }

            } //foreach

            do {
                $__uuid = Str::uuid();
                // Verifica si el UUID ya existe en la base de datos y si existe volvemos a generar el uuid
                //hacemos esto por estabilidad del sistema para estar seguros de que el uuid generado no este siendo utilizando
                // por otra carga masiva de registros
            } while (LoteProducto::where('uuid', $__uuid)->exists());

            //agregamos este campo porque al crear nuevos registro de forma masiva debemos saber que registro se insertaron de forma masiva,
            //todos los registros que tengan el mismo valor en su campo uuid significa que estos mismos se insertaron de forma masiva
            //asi evitaremos la inestabilidad del sistema ademas gracias a uuid sabremos que registros debemos devolver a  cada peticion http
            //no podemos hace esto con id_compra, ya que podria haber registros ya cargados anteriormente
            foreach ($__lote_productos as $values_lote_producto) {
                $lote_producto = new LoteProducto($values_lote_producto);
                $lote_producto->uuid = $__uuid;
                $lote_producto->status = true;
                $lote_producto->codigo = $this->generateCodigo($values_lote_producto['id_producto'], $values_lote_producto['id_compra']);
                $lote_producto->save();
            }

            $lote_producto = LoteProducto::join("productos", "productos.id", "=", "lote_productos.id_producto")
                ->join("depositos", "depositos.id", "=", "lote_productos.id_deposito")
                ->join("ciudades", "ciudades.id", "=", "depositos.id_ciudad")
                ->select(
                    "lote_productos.*",
                    "depositos.nombre_deposito",
                    "productos.nombre_producto",
                    "productos.marca",
                    "productos.img_producto",
                    "ciudades.nombres as ciudad",
                )
                ->where('lote_productos.uuid', $__uuid)
                ->get();

            return response()->json([
                'records' => $lote_producto,
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

    public function update(LoteProductoRequest $request): JsonResponse
    {
        try {
            $__lote_productos = $request->input("lote_productos");

            foreach ($__lote_productos as $values_lote_producto) {
                $request_lote_producto = $values_lote_producto;
            }

            //verificamos si deposito, producto y compra no estan eliminados
            //por estabilidad del sistema
            //el metodo exists() devuelve true si al menos hay un registros 
            $deposito = Deposito::where("status", true)
                ->where("id", $request_lote_producto['id_deposito'])
                ->exists();
            if (!$deposito) {
                return response()->json([
                    'records' => null,
                    'status' => false,
                    'message' => "El deposito con id {$request_lote_producto['id_deposito']} no se encuentra registrado en el sistema!",
                ], 404);
            }

            $producto = Producto::where("status", true)
                ->where("id", $request_lote_producto['id_producto'])
                ->exists();
            if (!$producto) {
                return response()->json([
                    'records' => null,
                    'status' => false,
                    'message' => "El producto con id {$request_lote_producto['id_producto']} no se encuentra registrado en el sistema!",
                ], 404);
            }

            $compra = Compra::where("status", true)
                ->where("id", $request_lote_producto['id_compra'])
                ->exists();
            if (!$compra) {
                return response()->json([
                    'records' => null,
                    'status' => false,
                    'message' => "La compra con id {$request_lote_producto['id_compra']} no se encuentra registrado en el sistema!",
                ], 404);
            }

            $lote_producto = LoteProducto::where('status', true)
                ->where('id', $request_lote_producto['id'])
                ->first();

            //verificamos si el regiustro existe por estabilidad del sistema
            if ($lote_producto == null) {
                return response()->json([
                    'record' => null,
                    'status' => false,
                    'message' => "Este registro no se encuentra en el sistema!",
                ], 404);
            }

            $lote_producto->update($request_lote_producto);

            $id_lote_producto = $lote_producto->id;
            $lote_producto = LoteProducto::join("productos", "productos.id", "=", "lote_productos.id_producto")
                ->join("depositos", "depositos.id", "=", "lote_productos.id_deposito")
                ->join("ciudades", "ciudades.id", "=", "depositos.id_ciudad")
                ->select(
                    "lote_productos.*",
                    "depositos.nombre_deposito",
                    "productos.nombre_producto",
                    "productos.marca",
                    "productos.img_producto",
                    "ciudades.nombres as ciudad",
                )
                ->where('lote_productos.id', $id_lote_producto)
                ->first();

            return response()->json([
                'record' => $lote_producto,
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

    public function destroy(Request $request): JsonResponse
    {
        try {
            $producto_lote = LoteProducto::where('status', true)
                ->where('id', $request->input('id'))
                ->first();

            //verificamos si el registro existe por estabilidad del sistema
            if ($producto_lote == null) {
                return response()->json([
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

    private function generateCodigo(int $id_producto, int $id_compra): string
    {
        $producto = Producto::select("nombre_producto")
            ->where("id", $id_producto)
            ->first();

        $documento_compra = DocumentoCompra::select("factura_nacional", "factura_importacion")
            ->where("id_compra", $id_compra)
            ->first();

        if ($documento_compra->factura_nacional != null) {
            //Si factura_nacional!=null  entonces generamos  codigo con el numero de factura_nacional
            $year = date('Y');
            $producto = strtoupper($producto->nombre_producto); //convertimos el nombre en mayuscula
            return "{$documento_compra->factura_nacional}-{$producto}-{$year}";
        } else {
            if ($documento_compra->factura_importacion != null) {
                //Si factura_importacion!=null  entonces generamos  codigo con el numero de factura_importacion
                $year = date('Y');
                $producto = strtoupper($producto->nombre_producto); //convertimos el nombre en mayuscula
                return "{$documento_compra->factura_importacion}-{$producto}-{$year}";
            } else {
                //si por alguna razon no se logra generar el codigo 
                return "CODIGO-NO-GENERADO";
            }
        } //if
    } //function
} //class
