<?php

namespace App\Http\Request\Admin\ProductCategories;

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
            'name' => 'required|unique:product_categories|string|max:255',
        ];
    }
}
