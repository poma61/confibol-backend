<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//add
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class ProductoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'nombre_producto' => 'required',
            'marca' => 'required',
            //este campo no se almacena enla base de datos es solo para recibir la imagen de tipo blob del lado del cliente
            'image_file' => ($this->isMethod('PUT')) ? 'sometimes|mimes:jpeg,jpg,png' : 'required|mimes:jpeg,jpg,png',
            'categoria' => 'required',
        ];
    }


    public function messages(): array
    {
        $messages = [
            'image_file.required' => 'El campo imagen del producto es requerido.',
            'image_file.mimes' => 'El campo imagen del producto debe ser un archivo de tipo: jpeg, jpg, png..',
        ];

        return $messages;
    }


    protected function failedValidation(Validator $validator): HttpResponseException
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Verificar los campos solicitados!',
            'validation_errors' => $validator->errors(),
        ], 422));
    }
} //class
