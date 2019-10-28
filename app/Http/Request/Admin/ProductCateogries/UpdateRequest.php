<?php

namespace App\Http\Request\Admin\ProductCategories;

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
            'name' => 'required|string|max:255|unique:product_categories,name,' . $this->product_category,
        ];
    }
}
