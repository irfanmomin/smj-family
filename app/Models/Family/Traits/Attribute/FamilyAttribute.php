<?php

namespace App\Models\Family\Traits\Attribute;

/**
 * Class FamilyAttribute.
 */
trait FamilyAttribute
{
    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn">'.
                $this->getViewFamilyButtonAttribute('edit-family', 'admin.family.editfamily').
                $this->getEditButtonAttribute('edit-family', 'admin.family.edit').
                $this->getDeleteButtonAttribute('delete-family', 'admin.family.deletefullfamily').
                '</div>';
    }

    /**
     * @return string
     */
    public function getActionButtonsMembersAttribute()
    {
        return '<div class="btn-group action-btn">'.
                $this->getViewFamilyButtonAttribute('edit-family', 'admin.family.editfamily').
                $this->getEditButtonAttribute('edit-family', 'admin.family.edit').
                $this->getDeleteButtonAttribute('delete-family', 'admin.family.deletefullfamily').
                $this->getCreditModalButtonAttribute('manage-main-trans', 'admin.family.deletefullfamily').
                '</div>';
    }

    /**
     * @return string
     */
    public function getCreditModalButtonAttribute($permission, $route)
    {
        if (access()->allow($permission) && transactionExist($this->id) > 0) {
            return '<a class="btn btn-success btn-flat btn-credit-payment-modal btn-mem-'.$this->id.'" href="'.route('admin.family.addpaymentmodal', $this).'" data-toggle="modal" data-target="#convertedInfoModal"><i data-toggle="tooltip" data-placement="top" title="Add Payment" class="fa fa-money"></i></a>';
        }
    }



    /**
     * @return string
     */
    public function getViewFamilyButtonAttribute($permission, $route)
    {
        if (access()->allow($permission)) {
            if ( isMainMember($this->id) == false ) {
                return '<a href="'.route($route, $this->family_id).'" class="btn btn-flat btn-default">
                    <i data-toggle="tooltip" data-placement="top" title="View Family" class="fa fa-eye"></i>
                </a>';
            }

            return '<a href="'.route($route, $this->id).'" class="btn btn-flat btn-default">
                    <i data-toggle="tooltip" data-placement="top" title="View Family" class="fa fa-eye"></i>
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

    /**
     * @return string
     */
    public function getEditButtonAttribute($permission, $route)
    {
        if ( access()->allow($permission) && access()->allow('view-all-members-list') ) {
            return '<a href="'.route($route, $this->id).'" class="btn btn-flat btn-default">
                    <i data-toggle="tooltip" data-placement="top" title="Edit" class="fa fa-pencil"></i>
                </a>';
        }
    }
}
