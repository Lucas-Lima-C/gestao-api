<?php

namespace App\Http\Requests;

use LaravelAux\BaseRequest;

class UserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        switch (request()->method()) {
            case "POST":
                $rules = [
                    'name' => 'required',
                    'email' => 'required|unique:users',
                    'password' => 'required',
                ];
                break;
            case "PUT":
                $rules = [
                    'name' => 'required',
                    'email' => 'required'
                ];
                break;
        }

        return $rules;
    }

    /**
     * Rules Messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => ':attribute é obrigatório',
            'email.unique' => 'O :attribute informado já está sendo utilizado',
            'integer' => 'O campo :attribute deve ser um número',
        ];
    }

    /**
     * Attributes Name
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Nome',
            'email' => 'E-mail',
            'password' => 'Senha',
            'photo' => 'Foto'
        ];
    }
}
