<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompraByCompDocumentoRequest;
use App\Models\Ciudad;
use App\Models\Compra;
use App\Models\DocumentoCompra;
use Illuminate\Http\Request;
use Throwable;

class CompraController extends Controller
{

    public function index(Request $request)
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
                    'documentos_compras.tipo_compra',
                    'documentos_compras.recibo',
                    'documentos_compras.factura_nacional',
                    'documentos_compras.lista_empaque',
                    'documentos_compras.poliza',
                    'documentos_compras.factura_importacion',
                    'documentos_compras.id_compra',
                    'compras.*',
                )
                ->where('compras.status', true)
                ->where('documentos_compras.status', true)
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
    } //index


    public function store(CompraByCompDocumentoRequest $request)
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

            //agregamos los documentos de la compra
            $documento_compra = new DocumentoCompra($request->input('documento_compra'));
            $documento_compra->status = true;
            $documento_compra->id_compra = $compra->id;
            $documento_compra->save();

            $id_compra = $compra->id;
            $compra = Compra::join('ciudades', 'ciudades.id', '=', 'compras.id_ciudad')
                ->join('documentos_compras', 'documentos_compras.id_compra', '=', 'compras.id')
                ->select(
                    'documentos_compras.tipo_compra',
                    'documentos_compras.recibo',
                    'documentos_compras.factura_nacional',
                    'documentos_compras.lista_empaque',
                    'documentos_compras.poliza',
                    'documentos_compras.factura_importacion',
                    'documentos_compras.id_compra',
                    'compras.*',
                )
                ->where('compras.id', $id_compra)
                ->first();

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

    public function update(CompraByCompDocumentoRequest $request)
    {
        try {
            $request_compra = $request->input("compra");
            $compra = Compra::where('status', true)
                ->where('id', $request_compra['id'])
                ->first();
            $documento_compra = DocumentoCompra::where('status', true)
                ->where('id_compra', $request_compra['id'])
                ->first();

            //verificamos si el registro existe por estabilidad del sistema
            if ($compra == null || $documento_compra == null) {
                return response()->json([
                    'record' => null,
                    'status' => false,
                    'message' => "Este registro no se encuentra en el sistema!",
                ], 404);
            }

            $compra->update($request_compra);

            //actualizamos los documentos compra
            $documento_compra->fill($request->input("documento_compra"));
            if ($request->input("documento_compra.tipo_compra") == "Nacional") {
                //cuando el tipo de compra es nacional 
                //los datos que corresponde a tipo de compra importacion deben ser null
                $documento_compra->factura_importacion = null;
                $documento_compra->lista_empaque = null;
                $documento_compra->poliza = null;
            } else {
                //cuando el tipo de compra es importacion 
                //los datos que corresponde a tipo de compra nacional deben ser null
                $documento_compra->factura_nacional = null;
                $documento_compra->recibo = null;
            }
            $documento_compra->update();

            $id_compra = $compra->id;
            $compra = Compra::join('ciudades', 'ciudades.id', '=', 'compras.id_ciudad')
                ->join('documentos_compras', 'documentos_compras.id_compra', '=', 'compras.id')
                ->select(
                    'documentos_compras.tipo_compra',
                    'documentos_compras.recibo',
                    'documentos_compras.factura_nacional',
                    'documentos_compras.lista_empaque',
                    'documentos_compras.poliza',
                    'documentos_compras.factura_importacion',
                    'documentos_compras.id_compra',
                    'compras.*',
                )
                ->where('compras.id', $id_compra)
                ->first();

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
            $compra = Compra::where('status', true)
                ->where('id', $request->input("compra.id"))
                ->first();
            $documento_compra = DocumentoCompra::where('status', true)
                ->where('id_compra', $request->input("compra.id"))
                ->first();

            //verificamos si el registro existe por estabilidad del sistema
            if ($compra == null || $documento_compra == null) {
                return response()->json([
                    'record' => null,
                    'status' => false,
                    'message' => "Este registro no se encuentra en el sistema!",
                ], 404);
            }

            $compra->status = false;
            $compra->update();
            $documento_compra->status = false;
            $documento_compra->update();

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
