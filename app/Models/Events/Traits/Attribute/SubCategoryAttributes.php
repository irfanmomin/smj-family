<?php

namespace App\Models\Events\Traits\Attribute;

/**
 * Class SubCategoryAttributes.
 */
trait SubCategoryAttributes
{
    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn">'.
                $this->getEditCategoryButtonAttribute('edit-category', 'admin.eventsubcategories.edit').
                $this->getDeleteButtonAttribute('delete-category', 'admin.eventsubcategories.destroy').
                '</div>';
    }

    /**
     * @return string
     */
    public function getEditCategoryButtonAttribute($permission, $route)
    {
        if (access()->allow($permission)) {
            return '<a href="'.route($route, $this->id).'" class="btn btn-flat btn-default">
                    <i data-toggle="tooltip" data-placement="top" title="Edit Category" class="fa fa-edit"></i>
                </a>';
        }
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute($permission, $route)
    {
        if (access()->allow($permission)) {
            return '<a href="'.route($route, $this->id).'"
                class="btn btn-flat btn-danger" data-method="delete"
                data-trans-button-cancel="'.trans('buttons.general.cancel').'"
                data-trans-button-confirm="'.trans('buttons.general.crud.delete').'"
                data-trans-title="'.trans('strings.backend.general.are_you_sure').'">
                    <i data-toggle="tooltip" data-placement="top" title="Delete" class="fa fa-trash"></i>
            </a>';
        }
    }
}
