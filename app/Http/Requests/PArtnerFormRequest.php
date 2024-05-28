<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class PartnerFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|max:150',
            'last_name' => 'required|max:150',
            'age' => 'required|max:2',
            'phone' => 'required|max:10',
            'phone_emergency' => 'required|max:10',
        ];
        return $rules;
    }
    public function messages()
    {
        $messages = [
            'name.required' => 'Campo nombre es necesario',
            'name.max' => 'Campo nombre solo permite 150 caracteres máximo',

            'last_name.required' => 'Campo primer apellido es necesario',
            'last_name.max' => 'Campo primer apellido solo permite 150 caracteres máximo',

            'age.required' => 'Campo edad es necesario',
            'age.max' => 'Campo edad solo permite 10 caracteres máximo',

            'phone.required' => 'Campo telefono es necesario',
            'phone.max' => 'Campo telefono solo permite 10 caracteres máximo',

            'phone_emergency.required' => 'Campo telefono de emergencia es necesario',
            'phone_emergency.max' => 'Campo telefono de emergencia solo permite 10 caracteres máximo',
        ];
        return $messages;
    }
}
