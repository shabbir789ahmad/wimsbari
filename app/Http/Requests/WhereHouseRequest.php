<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WhereHouseRequest extends FormRequest
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
            'where_house_name' => ['required', 'string', 'max:255', 'unique:where_houses'],
            'where_house_location' => '',
        ];
    }
}
