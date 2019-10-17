<?php

namespace App\Common\Users\Requests;


use App\Base\Requests\BaseMustAuthorizeFormRequest;
use App\Base\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends BaseMustAuthorizeFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8']
        ];
    }
}
