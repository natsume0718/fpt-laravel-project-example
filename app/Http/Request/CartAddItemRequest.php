<?php

namespace App\Http\Request;

use App\Http\Requests\AbstractAuthorizeFormRequest;

class CartAddItemRequest extends AbstractAuthorizeFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'required|integer|min:1',
            'quantity' => 'integer|min:1|max:10',
        ];
    }
}
