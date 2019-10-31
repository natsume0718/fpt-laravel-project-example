<?php

namespace App\Http\Request\Admin\Comments;

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
            'user_id' => 'required|integer|min:1',
            'product_id' => 'required|integer|min:1',
            'content' => 'required',
            'status' => 'integer|min:0|max:10',
        ];
    }
}
