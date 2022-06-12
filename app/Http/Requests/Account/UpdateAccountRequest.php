<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
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
            'is_entry'=>['bail','required','max:1'],
            'detail'=>['bail','required','max:10000'],
            'ammount'=>['bail','required','numeric', 'max:999999999'],
            'client_user_id'=>['bail','required','exists:users,id'],
            'store_id'=>['bail','required','exists:stores,id'],
            'administrator_user_id'=>['bail','required','exists:users,id'],

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
            'is_entry'=>'',
            'detail'=>'',
            'ammount'=>'',
            'client_user_id'=>'',
            'store_id'=>'',
            'administrator_user_id'=>'',

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
