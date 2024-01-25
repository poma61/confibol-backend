<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//add
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoteProductoRequest extends FormRequest
{
    public function rules(): array
    {
       $__lote_productos=$this->input("lote_productos");

       foreach( $__lote_productos  as $key => $lote_producto){
            $rules["lote_productos.{$key}.fecha_vencimiento"]="required|date";
            $rules["lote_productos.{$key}.costo_unitario"]="required|numeric";
            $rules["lote_productos.{$key}.cantidad"]="required|numeric|integer";
            $rules["lote_productos.{$key}.peso_neto"]="required|numeric";
            $rules["lote_productos.{$key}.unidad_medida_peso_neto"]="required";
            $rules["lote_productos.{$key}.id_producto"]="required|numeric";
            $rules["lote_productos.{$key}.id_compra"]="required|numeric";
            $rules["lote_productos.{$key}.id_deposito"]="required|numeric";
       }
        return $rules;
    }

    public function messages(): array
    {

        $__lote_productos=$this->input("lote_productos");

        foreach( $__lote_productos  as $key => $lote_producto){
             $messages["lote_productos.{$key}.fecha_vencimiento.required"]="El campo fecha vencimiento es requerido.";
             $messages["lote_productos.{$key}.fecha_vencimiento.date"]="El campo fecha vencimiento no es una fecha válida.";
             $messages["lote_productos.{$key}.costo_unitario.required"]="El campo costo unitario es requerido.";
             $messages["lote_productos.{$key}.costo_unitario.numeric"]="El campo costo unitario debe ser un número.";
             $messages["lote_productos.{$key}.cantidad.required"]="El campo cantidad es requerido.";
             $messages["lote_productos.{$key}.cantidad.numeric"]="El campo cantidad debe ser un número.";
             $messages["lote_productos.{$key}.cantidad.integer"]="El campo cantidad debe ser un entero.";
             $messages["lote_productos.{$key}.peso_neto.required"]="El campo peso neto es requerido.";
             $messages["lote_productos.{$key}.peso_neto.numeric"]="El campo peso neto debe ser un número.";
             $messages["lote_productos.{$key}.unidad_medida_peso_neto.required"]="El campo unidad de medida es requerido.";
             $messages["lote_productos.{$key}.id_producto.required"]="El campo producto es requerido.";
             $messages["lote_productos.{$key}.id_producto.numeric"]="El campo producto debe ser un número.";
             $messages["lote_productos.{$key}.id_deposito.required"]="El campo deposito es requerido.";
             $messages["lote_productos.{$key}.id_deposito.numeric"]="El campo deposito debe ser un número.";
        }
 
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
}
