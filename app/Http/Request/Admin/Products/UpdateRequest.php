<?php

namespace App\Http\Request\Admin\Products;

use App\Http\Requests\AbstractAuthorizeFormRequest;

class UpdateRequest extends AbstractAuthorizeFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'user_id' => 'required|integer|min:1',
            'content' => 'required',
            'price' => 'required|numeric|min:0',
            'discount' => 'required|min:0|max:100',
            'product_category_id' => 'integer|min:1',
            'status' => 'integer|min:0|max:10',
        ];
    }
}
