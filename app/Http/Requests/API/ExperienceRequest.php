<?php

namespace App\Http\Requests\API;

use App\Models\LanguageString;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ExperienceRequest extends FormRequest
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
            'about_your_certification'     => 'required',
            'exp_from'     => 'required',
            'location'     => 'required',
            'company_label'     => 'required',
            'title'     => 'required',
        ];
    }

    public function messages()
    {
        return $messages = [
            'required' => 'the_field_is_required',
            'string' => 'the_string_field_is_required',
            'max' => 'the_field_is_out_from_max',
            'min' => 'the_field_is_low_from_min',
            'unique' => 'the_field_should_unique',
            'confirmed' => 'the_field_should_confirmed',
            'email' => 'the_field_should_email',
            'exists' => 'the_field_should_exists',
        ];

    }

    public function failedValidation(Validator $validator)
    {
        //write your bussiness logic here otherwise it will give same old JSON response

        $errors = [];
        foreach ($validator->errors()->messages() as $field => $message) {

            $messageval = LanguageString::translated()->where('name_key', $message[0] )->first()->name;
            $field_msg = LanguageString::translated()->where('name_key', $field )->first()->name;
            $errors[] = [
                'field' => $field,
                'message' => strtolower($field_msg) . ' ' . strtolower($messageval),
            ];
        }


        throw new HttpResponseException(response()->json(['errors' => $errors], 422));
    }
}
