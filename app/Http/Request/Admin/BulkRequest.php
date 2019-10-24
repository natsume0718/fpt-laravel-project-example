<?php

namespace App\Http\Request\Admin;

use App\Http\Requests\AbstractAuthorizeFormRequest;

class BulkRequest extends AbstractAuthorizeFormRequest
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
