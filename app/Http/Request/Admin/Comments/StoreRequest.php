<?php

namespace App\Http\Request\Admin\Comments;

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
            'name' => 'required|max:255',
            'user_id' => 'required|integer|min:1',
            'product_id' => 'required|integer|min:1',
            'content' => 'required',
            'status' => 'integer|min:0|max:10',
        ];
    }
}
