<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//add
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class PersonalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'nombres' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'cargo' => 'required',
            'n_de_contacto' => 'required|numeric|integer',
            'ci' => [
                'required',
                //aplicar la validacion unique cuando el campo status este en true siginifica que el registto no esta eliminado
                //aplicamos el ignore cuando sea un update ya que el ci puede ser el mismo porque es una actualizacion del registro
                Rule::unique('personals')->where(function ($query) {
                    $query->where('status', true);
                })->ignore($this->input('id')),
            ],
            'ci_expedido' => 'required',
            'direccion' => 'required',
        ];
        if ($this->isMethod('PUT')) {
            $rules['image_file'] = 'sometimes|mimes:jpeg,png,jpg';
        } else {
            $rules['image_file'] = 'required|mimes:jpeg,png,jpg';
        }

        //empty => devuelve false cuando la variable NO esta vacia y/o null o cuando SI tiene contenido
        if (empty($this->input('correo_electronico')) == false) {
            $rules['correo_electronico'] = [
                'email',
                //aplicar la validacion unique cuando el campo status este en true siginifica que el registto no esta eliminado
                //aplicamos el ignore cuando sea un update ya que el ci puede ser el mismo porque es una actualizacion del registro
                Rule::unique('personals')->where(function ($query) {
                    $query->where('status', true);
                })->ignore($this->input('id')),
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'image_file.required' => 'El campo foto es requerido.',
            'image_file.mimes' => 'El campo foto debe ser un archivo de tipo: jpeg, jpg, png.',
        ];
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
