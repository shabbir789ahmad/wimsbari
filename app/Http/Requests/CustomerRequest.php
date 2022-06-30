<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
         'customer_group'=>'required',
          'customer_name'=>'required',
          'customer_address'=>'required',
          'customer_company'=>'required',
          'customer_city'=>'required',
          'customer_email'=>'required',
           'customer_phone'=>'required',
           'customer_image'=>'',
        ];
    }
}
