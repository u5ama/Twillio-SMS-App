<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class SmtpCredentialStoreRequest extends FormRequest
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
        return [
            'mail_driver'       => 'required',
            'mail_host'         => 'required',
            'mail_port'         => 'required|numeric',
            'mail_username'     => 'required|unique:smtp_credentials,mail_username,' . $this->edit_value,
            'mail_from_address' => 'required',
            'mail_password'     => 'required',
            'mail_encryption'   => 'required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        //write your bussiness logic here otherwise it will give same old JSON response
        throw new HttpResponseException(response()->json(['success' => false, 'message' => $validator->errors()->first()], 422));
    }
}
