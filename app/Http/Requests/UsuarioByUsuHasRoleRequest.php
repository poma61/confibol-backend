<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//add
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class UsuarioByUsuHasRoleRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            // si estamos haciendo un update debe permitir el ingreso del mismo usuario en caso de que no se modifique
            //aqui no hacemos el unique segun el status.. ya que son datos para iniciar sesion y en la base de datos user esta como unique
            //estos datos son sensibles por eso colocamos unique de forma segura sin depender del status del rgistro
            'user' => 'required|unique:usuarios,user,' . $this->input('id'),
            'id_personal' => 'required',
            //usuario_has_role
            'id_role' => 'required',
        ];

        //si se esta editando el registro.. entonces el password ya no es obligatorio
        if ($this->isMethod('PUT')) {
            //empty => devuelve false cuando la variable NO  esta vacia y/o null
            //ejemplo password="1237596"
            if (empty($this->input('password')) == false) {
                $rules['password'] = 'min:8';
            }
        } else {
            $rules['password'] = 'required|min:8';
        }

        return $rules;
    }
    public function messages(): array
    {
        return [
            //usuario
            'id_personal.required' => 'El campo personal es requerido.',
            'user.required' => 'El campo usuario es requerido.',
            'password.required' => 'El campo contraseña es requerido.',
            'password.min' => 'El campo contraseña debe tener al menos 8 caracteres.',
            //usuarios_has_roles
            'id_role.required' => 'El campo rol es requerido.',
        ];
    }


    protected function failedValidation(Validator $validator): HttpResponseException
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Verificar los campos!',
            'validation_errors' => $validator->errors(),
        ], 422));
    }

} //class
