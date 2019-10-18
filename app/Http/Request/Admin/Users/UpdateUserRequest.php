<?php

namespace App\Http\Request\Admin\Users;

use App\Http\Requests\AbstractAuthorizeFormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends AbstractAuthorizeFormRequest
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
