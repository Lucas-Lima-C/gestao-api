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
                    'email' => 'required|unique:users|email:rfc,dns',
                    'password' => 'required|min:6',
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
            'email.email' => 'O :attribute não é válido',
            'min' => 'A :attribute precisa ter no mínimo 6 caracteres',
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
