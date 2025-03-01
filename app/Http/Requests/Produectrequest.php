<?php

namespace App\Http\Requests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class Produectrequest extends FormRequest
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
            'name_en'=>['required','min:3','max:50','string'],
            'name_ar'=>['required','min:3','max:50','string'],
            'des_ar'=> ['required','min:3','max:500','string'],
            'des_en'=> ['required','min:3','max:500','string'],
            'status'=> ['required','in:active,not active'],
            'quantity'=> ['required','numeric','max:500'],
            'price'=> ['required','numeric','min:1'],
            'discount_price'=> ['nullable','numeric'],
            'discount'=> ['nullable','numeric'],
            'status'=> ['required','in:active,not active'],
         'images'=> ['nullable'],
 
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
