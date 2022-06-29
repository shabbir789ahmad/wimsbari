<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
             'brand_id' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'product_name' => 'required',
            'product_price_piece'=>'required',
            'stock' => 'required',
            'purchasing_price' => 'required',
            'where_house_id' => 'required',
        ];
    }
}
