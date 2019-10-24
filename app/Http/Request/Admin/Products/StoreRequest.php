<?php

namespace App\Http\Request\Admin\Products;

use App\Http\Requests\AbstractAuthorizeFormRequest;

class StoreRequest extends AbstractAuthorizeFormRequest
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
