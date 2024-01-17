<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//add
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class CompraRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            //compra
            'compra.fecha_compra' => 'required|date',
            //compra documentos
            'compra.tipo_compra' => 'required',

        ];

        foreach ($this->input('producto_lotes') as $key => $item) {
            //verificar que ningun campo 
            //producto_lotes=> es el nombre del array de objetos que se envia desde el frontend
            $rules["producto_lotes.{$key}.fecha_vencimiento"] = 'required|date';
            $rules["producto_lotes.{$key}.cantidad"] = 'required|numeric';
            $rules["producto_lotes.{$key}.costo_unitario"] = 'required|numeric';
            $rules["producto_lotes.{$key}.id_producto"] = 'required|numeric';
            $rules["producto_lotes.{$key}.id_deposito"] = 'required|numeric';
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            //compra
            'compra.fecha_compra.required' => 'El campo fecha compra es requerido.',
            'compra.fecha_compra.date' => 'El campo fecha compra no es una fecha válida.',
            'compra.tipo_compra.required' => 'El campo tipo de compra es requerido.',
        ];

        foreach ($this->input('producto_lotes') as $key => $client) {
            //verificar que ningun campo 
            //producto_lotes=> es el nombre del array de objetos que se envia desde el frontend
            $rules["producto_lotes.{$key}.fecha_vencimiento.required"] = 'El fecha vencimiento es requerido.';
            $rules["producto_lotes.{$key}.fecha_vencimiento.date"] = 'El campo fecha vencimiento no es una fecha válida.';
            $rules["producto_lotes.{$key}.cantidad.required"] = 'El campo cantidad es requerido.';
            $rules["producto_lotes.{$key}.costo_unitario.required"] = 'El campo costo unitario es requerido.';
            $rules["producto_lotes.{$key}.id_producto.required"] = 'El campo id producto es requerido.';
            $rules["producto_lotes.{$key}.id_deposito.required"] = 'El campo id deposito es requerido.';
        }

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
