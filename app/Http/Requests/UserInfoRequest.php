<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address' => ['string', 'max:100', 'nullable'],
            'phonenumber' => ['max:200'],
            'bio' => ['max:25'],
            'dateofbirth' => ['date','before:today', 'date_format:Y-m-d', 'nullable']
        ];
    }
}
