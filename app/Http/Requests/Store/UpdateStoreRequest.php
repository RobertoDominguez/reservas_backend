<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreRequest extends FormRequest
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
            'url_map'=>['bail','required','min:1', 'max:250'],
            'days'=>['bail','required','min:1', 'max:250'],
            'location'=>['bail','required','min:1', 'max:250'],
            'ico'=>['bail','file', 'max:10240','mimes:jpg,bmp,png,jpeg'],
            'logo'=>['bail','file', 'max:10240','mimes:jpg,bmp,png,jpeg'],
            'mision'=>['bail','required','max:10000'],
            'vision'=>['bail','required','max:10000'],
            'phone'=>['bail','required','numeric', 'max:999999999'],
            'facebook'=>['bail','required','min:1', 'max:250'],
            'twitter'=>['bail','required','min:1', 'max:250'],
            'tik_tok'=>['bail','required','min:1', 'max:250'],
            'youtube'=>['bail','required','min:1', 'max:250'],
            'whatsapp'=>['bail','required','numeric', 'max:999999999'],
            'qr'=>['bail','file', 'max:10240','mimes:jpg,bmp,png,jpeg'],
            'is_open'=>['bail','required','max:1'],
            'days_subscription'=>['bail','required','numeric', 'max:999999999'],

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
            'url_map'=>'',
            'days'=>'',
            'location'=>'',
            'ico'=>'',
            'logo'=>'',
            'mision'=>'',
            'vision'=>'',
            'phone'=>'',
            'facebook'=>'',
            'twitter'=>'',
            'tik_tok'=>'',
            'youtube'=>'',
            'whatsapp'=>'',
            'qr'=>'',
            'is_open'=>'',
            'days_subscription'=>'',

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
