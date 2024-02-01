<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//add
use App\Http\Requests\PersonalRequest;
use App\Models\Ciudad;
use App\Models\Personal;
use Illuminate\Support\Facades\Storage;
use Throwable;

class PersonalController extends Controller
{

    public function index(Request $request)
    {
        try {
            $ciudad = Ciudad::where('nombre_ciudad', $request->input('ciudad'))
                ->first();
            //debemos verificar si la ciudad existe en la base de datos por seguridad y estabilidad del sistema
            if ($ciudad == null) {
                return response()->json([
                    'records' => null,
                    'status' => false,
                    'message' => "No se encontro la ciudad de {$request->input('ciudad')}!",
                ], 404);
            }

            $personal = Personal::join('ciudades', 'ciudades.id', '=', 'personals.id_ciudad')
                ->select('personals.*')
                ->where('personals.status', true)
                ->where('ciudades.id', $ciudad->id)
                ->get();

            return response()->json([
                'records' => $personal,
                'status' => true,
                'message' => 'OK',
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'records' => null,
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function store(PersonalRequest $request)
    {
        try {
            $ciudad = Ciudad::where('nombre_ciudad', $request->input('ciudad'))
                ->first();
            //debemos verificar si la ciudad existe en la base de datos por seguridad y estabilidad del sistema
            if ($ciudad == null) {
                return response()->json([
                    'record' => null,
                    'status' => false,
                    'message' => "No se encontro la ciudad de {$request->input('ciudad')}!",
                ], 404);
            }

            $personal = new Personal($request->except(['foto_image_path', 'image_file']));
            $image_path = $request->file('image_file')->store('img/personal', 'public');
            $personal->foto_image_path = "/storage/{$image_path}";
            $personal->id_ciudad = $ciudad->id;
            $personal->status = true;
            $personal->save();

            return response()->json([
                'record' => $personal,
                'status' => true,
                'message' => 'Registro creado!',
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'record' => null,
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    } //store


    public function update(PersonalRequest $request)
    {
        try {
            $ciudad = Ciudad::where('nombre_ciudad', $request->input('ciudad'))
                ->first();
            //debemos verificar si la ciudad existe en la base de datos por seguridad y estabilidad del sistema
            if ($ciudad == null) {
                return response()->json([
                    'record' => null,
                    'status' => false,
                    'message' => "No se encontro la ciudad de {$request->input('ciudad')}!",
                ], 404);
            }

            $personal = Personal::where('status', true)
                ->where('id', $request->input('id'))
                ->first();

            //verificamos si el registro se encuentra por estabilidad del sistema
            if ($personal == null) {
                return response()->json([
                    'record' => null,
                    'status' => false,
                    'message' => 'Este registro no se encuentra en el sistema!',
                ], 404);
            }

            $personal->fill($request->except(['image_file', 'foto_image_path']));
            //verificar si subio una nueva imagen
            if ($request->file('image_file') != null) {
                Storage::disk('public')->delete(str_replace("/storage", "", $personal->foto_image_path));
                $image_path = $request->file('image_file')->store('img/personal', 'public');
                $personal->foto_image_path = "/storage/{$image_path}";
            }
            $personal->update();

            return response()->json([
                'record' => $personal,
                'status' => true,
                'message' => 'Registro actualizado!',
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'record' => null,
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    } //update


    public function destroy(Request $request)
    {
        try {
            $personal = Personal::where('status', true)
                ->where('id', $request->input('id'))
                ->first();

            //verificamos si el registro se encuentra por estabilidad del sistema
            if ($personal == null) {
                return response()->json([
                    'record' => null,
                    'status' => false,
                    'message' => 'Este registro no se encuentra en el sistema!',
                ], 404);
            }

            $personal->status = false;
            $personal->update();

            return response()->json([
                'status' => true,
                'message' => 'Registro eliminado!',
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function recordByCi(Request $request)
    {
        try {
            $ciudad = Ciudad::where('nombre_ciudad', $request->input('ciudad'))
                ->first();

            //debemos verificar si la ciudad existe en la base de datos por seguridad y estabilidad del sistema
            if ($ciudad == null) {
                return response()->json([
                    'record' => null,
                    'status' => false,
                    'message' => "No se encontro la ciudad de {$request->input('ciudad')}!",
                ], 404);
            }

            $personal = Personal::join('ciudades', 'ciudades.id', '=', 'personals.id_ciudad')
                ->select(
                    'personals.id',
                    'personals.nombres',
                    'personals.apellido_paterno',
                    'personals.apellido_materno',
                )
                ->where('personals.status', true)
                ->where('personals.ci', $request->input('ci'))
                ->where('ciudades.id', $ciudad->id)
                ->first();

            if ($personal == null) {
                return response()->json([
                    'record' => null,
                    'message' => "No se encontro ningun personal con C.I. número {$request->input('ci')}, verifique si el personal
                                  se encuentra registrado en el sistema y/o el personal no pertence a la ciudad de
                                   {$request->input('ciudad')}.",
                    'status' => false,
                ], 404);
            } else {
                return response()->json([
                    'record' => $personal,
                    'message' => "Se encontro un registro con C.I. número {$request->input('ci')}.",
                    'status' => true,
                ], 200);
            }
        } catch (Throwable $th) {
            return response()->json([
                'record' => null,
                'message' => $th->getMessage(),
                'status' => false,
            ], 500);
        }
    }
} //class



