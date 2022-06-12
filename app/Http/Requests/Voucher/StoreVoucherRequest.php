<?php

namespace App\Http\Requests\Voucher;

use Illuminate\Foundation\Http\FormRequest;

class StoreVoucherRequest extends FormRequest
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
            'image'=>['bail','file', 'max:10240','mimes:jpg,bmp,png,jpeg'],
            'accepted'=>['bail','required','max:1'],
            'rejected'=>['bail','required','max:1'],
            'message'=>['bail','required','min:1', 'max:250'],
            'total'=>['bail','required','numeric', 'max:999999999'],
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
            'image'=>'',
            'accepted'=>'',
            'rejected'=>'',
            'message'=>'',
            'total'=>'',
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
