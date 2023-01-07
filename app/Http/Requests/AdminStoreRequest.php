<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class AdminStoreRequest extends FormRequest
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
            'name'      => 'required',
            'mobile_no' => 'required|numeric',
            'email'     => 'required|max:255|unique:admins,email,' . $this->edit_value,
            'role_id'   => 'required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        //write your bussiness logic here otherwise it will give same old JSON response
        throw new HttpResponseException(response()->json(['success' => false, 'message' => $validator->errors()->first()], 422));
    }
}
