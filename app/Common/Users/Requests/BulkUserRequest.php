<?php

namespace App\Common\Users\Requests;

use App\Base\Requests\BaseMustAuthorizeFormRequest;

class BulkUserRequest extends BaseMustAuthorizeFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ids' => ['required'],
        ];
    }
}
