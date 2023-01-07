<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UserAddressStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'address' => 'required',
            'user_id' => 'required_if:edit_value,',
            'latitude' => 'required',
            'longitude' => 'required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        //write your bussiness logic here otherwise it will give same old JSON response
        throw new HttpResponseException(response()->json(['success' => false, 'message' => $validator->errors()->first()], 422));
    }
}
