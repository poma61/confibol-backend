<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//add
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;


class DepositoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'nombre_deposito' => 'required',
            'direccion' => 'required',
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

}//class
