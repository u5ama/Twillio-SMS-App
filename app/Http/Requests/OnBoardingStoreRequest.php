<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class OnBoardingStoreRequest extends FormRequest
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
			'*_header_text' => 'required',
			'*_description' => 'required',
			'edit_value'    => 'required',
			'icon'          => 'mimes:jpeg,png,jpg|required_if:edit_value, ==, 0',
			'image'         => 'image|mimes:jpeg,png,jpg|required_if:edit_value, ==, 0',
		];
	}

	public function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(response()->json(['message' => $validator->errors()->first()], 422));
	}
}
