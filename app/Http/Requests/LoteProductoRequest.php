<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//add
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class LoteProductoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'fecha_vencimiento' => 'required|date',
            'cantidad' => 'required|numeric|integer',
            'costo_unitario' => 'required|numeric',
            'id_producto' => 'required|numeric',
            'id_compra' => 'required|numeric',
            'id_deposito' => 'required|numeric',
        ];
    }

    protected function failedValidation(Validator $validator): HttpResponseException
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Verificar los campos solicitados!',
            'validation_errors' => $validator->errors(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
