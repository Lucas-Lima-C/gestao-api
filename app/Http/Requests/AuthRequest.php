<?php

namespace App\Http\Requests;

use LaravelAux\BaseRequest;

class AuthRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required'
        ];
    }

    /**
     * Validation Messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório'
        ];
    }

    /**
     * Validation Attributes
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'email' => 'E-mail',
            'password' => 'Senha'
        ];
    }
}
