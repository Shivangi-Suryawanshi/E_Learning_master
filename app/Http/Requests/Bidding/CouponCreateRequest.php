<?php

namespace App\Http\Requests\Bidding;

use Illuminate\Foundation\Http\FormRequest;

class CouponCreateRequest extends FormRequest
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
            'title'=>'required',
            'discount'=>'required',
            'coupon_code'=>'required|unique:coupon_code',
            'description'=>'required',
            'validity_from' =>'required',
            'validity_to' =>'required'
        ];
    }
}
