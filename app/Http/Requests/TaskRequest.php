<?php

namespace App\Http\Requests;

use LaravelAux\BaseRequest;

class TaskRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'date_of_conclusion' => 'required'
        ];
    }

    /**
     * Validation messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => ':attribute é obrigatório',
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
            'name' => 'Título',
            'date_of_conclusion' => 'Data de Conclusão'
        ];
    }
}