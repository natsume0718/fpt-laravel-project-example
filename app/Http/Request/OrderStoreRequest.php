<?php

namespace App\Http\Request;

use App\Http\Requests\AbstractAuthorizeFormRequest;

class OrderStoreRequest extends AbstractAuthorizeFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_phone_number' => 'required|string',
            'customer_address' => 'required|string',
        ];
    }
}
