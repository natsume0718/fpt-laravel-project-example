<?php

namespace App\Http\Request;

use App\Http\Requests\AbstractAuthorizeFormRequest;

class ChangeUserInformationRequest extends AbstractAuthorizeFormRequest
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
            'email' => ['required', 'email', 'unique:users,email,' . auth()->user()->id],
        ];
    }
}
