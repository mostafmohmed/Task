<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class orderrequesr extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'user_id'=>['required','exists:users,id'],
            'user_name'=>['required','string','min:2','max:50'],
            'address_name'=>['required','string','min:4','max:100'],
            'building_number'=>['required','string','max:100'],
            // 'total_price'=>['required','string','min:1','numeric'],
            'user_phone'=>['required','regex:/(01)[0-9]{9}/','numeric'],
            'payment_method'=>['required','in:Stripe,paypal'],
            'status'=>['in:panding,shipped,deliverd'],
            'country'=>['required','string','max:100'],

           
        ];
    }
    public function failedValidation(Validator $validator)
    {
       throw new HttpResponseException(response()->json([
         'success'   => false,
         'message'   => 'Validation errors',
         'data'      => $validator->errors()
       ]));
    }
}
