<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VegetableRequest extends FormRequest
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
            'name' => 'required|max:255',
            'picturePath' => 'required|image',
            'description' => 'required',
            'purchase_in' => 'required|max:255|in:kg,bunch(es)',
            'minimum_purchase' => 'required|integer',
            'price' => 'required|integer',
            'rate' => 'required|numeric',
            'types' => ''
        ];
    }
}
