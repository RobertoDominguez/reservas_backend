<?php

namespace App\Http\Requests\Open;

use Illuminate\Foundation\Http\FormRequest;

class StoreOpenRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

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
            'begin_time'=>['bail','required','date_format:H:i'],
            'end_time'=>['bail','required','date_format:H:i'],
            'day'=>['bail','required','min:1', 'max:250'],
            'store_id'=>['bail','required','exists:stores,id'],

        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'begin_time'=>'',
            'end_time'=>'',
            'day'=>'',
            'store_id'=>'',

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
