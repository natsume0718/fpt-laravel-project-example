<?php

namespace App\Http\Request\Admin\Users;

use App\Http\Requests\AbstractAuthorizeFormRequest;

class DestroyUserRequest extends AbstractAuthorizeFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }
}
