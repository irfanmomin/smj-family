<?php

namespace App\Http\Requests\Backend\Family;

use App\Http\Requests\Request;

/**
 * Class DeleteFamilyRequest.
 */
class DeleteFamilyRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('delete-family');
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
