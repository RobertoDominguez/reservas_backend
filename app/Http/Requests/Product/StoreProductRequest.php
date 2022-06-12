<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name'=>['bail','required','min:1', 'max:250'],
            'price'=>['bail','required','numeric', 'max:999999999'],
            'description'=>['bail','required','max:10000'],
            'image'=>['bail','file', 'max:10240','mimes:jpg,bmp,png,jpeg'],
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
            'name'=>'',
            'price'=>'',
            'description'=>'',
            'image'=>'',
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
