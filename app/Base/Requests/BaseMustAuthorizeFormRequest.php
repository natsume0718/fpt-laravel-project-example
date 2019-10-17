<?php


namespace App\Base\Requests;


use Illuminate\Foundation\Http\FormRequest;

abstract class BaseMustAuthorizeFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
