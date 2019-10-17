<?php

namespace App\Common\Users\Requests;

use App\Base\Requests\BaseMustAuthorizeFormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends BaseMustAuthorizeFormRequest
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
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->segment(3))]
        ];
    }
}
