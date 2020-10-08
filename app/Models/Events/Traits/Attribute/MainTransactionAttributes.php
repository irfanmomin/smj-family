<?php

namespace App\Models\Events\Traits\Attribute;

/**
 * Class MainTransactionAttributes.
 */
trait MainTransactionAttributes
{
    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn">'.
                $this->getEditCategoryButtonAttribute('manage-main-trans', 'admin.maintransactions.showchildtranslist').
                $this->getDeleteButtonAttribute('delete-main-trans', 'admin.maintransactions.destroy').
                '</div>';
    }

    /**
     * @return string
     */
    public function getEditCategoryButtonAttribute($permission, $route)
    {
        if (access()->allow($permission)) {
            return '<a href="'.route($route, $this->id).'" class="btn btn-flat btn-default">
                    <i data-toggle="tooltip" data-placement="top" title="View Transactions" class="fa fa-eye"></i>
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
