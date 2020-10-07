<?php

namespace App\Http\Controllers\Backend\Family;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Family\ManageMembersListRequest;
use App\Repositories\Backend\Family\FamilyRepository;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class AllMembersTableController.
 */
class AllMembersTableController extends Controller
{
    protected $family;

    /**
     * @param \App\Repositories\Backend\Family\FamilyRepository $cmspages
     */
    public function __construct(FamilyRepository $family)
    {
        $this->family = $family;
    }

    /**
     * @param \App\Http\Requests\Backend\Family\ManageMembersListRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageMembersListRequest $request)
    {
        return Datatables::of($this->family->getForAllMembersListDataTable($request))
            ->escapeColumns(['id'])
            ->filterColumn('fullname', function($query, $keyword) {
                $query->whereRaw("firstname like ?", ["%$keyword%"])->orWhereRaw("lastname like ?", ["%$keyword%"])->orWhereRaw("surname like ?", ["%$keyword%"]);
            })
            /* ->filterColumn('pending_amount', function($query, $keyword) {
                $query->whereRaw("smj_members_pending_amount.pending_amount like ?", ["%$keyword%"]);
            }) */
            ->filterColumn('pending_amount_hidden', function($query, $keyword) {
                $query->whereRaw("smj_members_pending_amount.pending_amount like ?", ["%$keyword%"]);
            })
            ->filterColumn('areacity', function($query, $keyword) {
                $query->whereRaw("area like ?", ["%$keyword%"])->orWhereRaw("city like ?", ["%$keyword%"]);
            })
            ->addColumn('fullname', function ($family) {
                return $family->fullname;
            })
            ->addColumn('pending_amount_hidden', function ($family) {
                if (!is_null($family->pending_amount)) {
                    return '<h4><span class="label label-warning">&#x20B9; '.$family->pending_amount.'</span></h4>';
                }
            })
            ->filterColumn('creatorName', function($query, $keyword) {
                $query->whereRaw("CONCAT(users.first_name, ' ', users.last_name) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('created_at', function ($family) {
                return date('d/m/Y h:i A', strtotime($family->created_at));
            })
            ->addColumn('is_main', function ($family) {
                if ($family->is_main == 1) {
                    return '<span class="label label-success">YES</span>';
                } else if ($family->is_main == '0') {
                    return '';
                } else {
                    return '-';
                }
            })
           /*  ->addColumn('pending_amount', function ($family) {
                return $family->pending_amount;
            }) */
            ->addColumn('is_verified', function ($family) {
                if ($family->is_verified == 1) {
                    return '';
                } else if ($family->is_verified == 0) {
                    return '<span class="label label-danger">Not Verified</span>';
                } else {
                    return '-';
                }
            })
            ->addColumn('actions', function ($family) {
                return $family->action_buttons_members;
            })
            /* ->rawColumns(['action_addamount'])
            ->editColumn('action_addamount', function ($maintrans) {
                return '<a class="btn btn-success btn-flat btn-credit-payment-modal" href="'.route('admin.family.addpaymentmodal', $this).'" data-toggle="modal" data-target="#convertedInfoModal"><i data-toggle="tooltip" data-placement="top" title="Add Payment" class="fa fa-money"></i></a>';
            }) */
            ->make(true);
    }
}
