<?php

namespace App\Http\Request;

use App\Http\Requests\AbstractAuthorizeFormRequest;

class AbstractCRUDIndexRequest extends AbstractAuthorizeFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sort_field' => 'string',
            'sort_by' => 'string',
            'per_page' => 'integer'
        ];
    }
}
