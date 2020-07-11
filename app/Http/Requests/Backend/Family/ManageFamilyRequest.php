<?php

namespace App\Http\Requests\Backend\Family;

use App\Http\Requests\Request;

/**
 * Class ManageFamilyRequest.
 */
class ManageFamilyRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('view-family-list');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
