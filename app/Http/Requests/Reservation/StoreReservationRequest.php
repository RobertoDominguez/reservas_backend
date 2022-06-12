<?php

namespace App\Http\Requests\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
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
            'user_name'=>['bail','required','min:1', 'max:250'],
            'date'=>['bail','required','date'],
            'time'=>['bail','required','date_format:H:i'],
            'accepted'=>['bail','required','max:1'],
            'rejected'=>['bail','required','max:1'],
            'message'=>['bail','required','min:1', 'max:250'],
            'image'=>['bail','file', 'max:10240','mimes:jpg,bmp,png,jpeg'],
            'store_id'=>['bail','required','exists:stores,id'],
            'service_id'=>['bail','required','exists:services,id'],
            'client_user_id'=>['bail','required','exists:users,id'],

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
            'user_name'=>'',
            'date'=>'',
            'time'=>'',
            'accepted'=>'',
            'rejected'=>'',
            'message'=>'',
            'image'=>'',
            'store_id'=>'',
            'service_id'=>'',
            'client_user_id'=>'',

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
