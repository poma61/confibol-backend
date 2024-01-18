<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

//add
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;


class CompraByCompDocumentoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return   [
            //compra
            'compra.fecha_compra' => 'required|date',
            //compra documentos
            'documento_compra.tipo_compra' => 'required',
        ];
    }

    public function messages(): array
    {
        $messages = [
            //compra
            'compra.fecha_compra.required' => 'El campo fecha compra es requerido.',
            'compra.fecha_compra.date' => 'El campo fecha compra no es una fecha válida.',
            'documento_compra.tipo_compra.required' => 'El campo tipo de compra es requerido.',
        ];

        return $messages;
    }

    protected function failedValidation(Validator $validator): HttpResponseException
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Verificar los campos solicitados!',
            'validation_errors' => $validator->errors(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}//class
