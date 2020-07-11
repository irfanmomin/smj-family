<?php

namespace App\Http\Requests\Backend\Family;

use App\Http\Requests\Request;

/**
 * Class ManageMembersListRequest.
 */
class ManageMembersListRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('view-all-members-list');
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
