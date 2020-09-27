<?php

namespace App\Http\Controllers\Backend\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Family\ManageMembersListRequest;
use App\Repositories\Backend\Events\MainTransactionRepository;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Events\Transaction;

/**
 * Class ChildTransactionListTableController.
 */
class ChildTransactionListTableController extends Controller
{
    protected $maintrans;

    /**
     * @param \App\Repositories\Backend\Family\MainTransactionRepository $maintrans
     */
    public function __construct(MainTransactionRepository $maintrans)
    {
        $this->maintrans = $maintrans;
    }

    /**
     * @param \App\Http\Requests\Backend\Family\ManageMembersListRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageMembersListRequest $request)
    {
        return Datatables::of($this->maintrans->getForAllChildTransListDataTable($request))
            ->escapeColumns(['id'])
            /* ->addColumn('member_name', function ($maintrans) {
                return $maintrans->fullname;
            }) */
            ->filterColumn('member_name', function($query, $keyword) {
                $query->whereRaw("members.firstname like ?", ["%$keyword%"])->orWhereRaw("members.lastname like ?", ["%$keyword%"])->orWhereRaw("members.surname like ?", ["%$keyword%"]);
            })
            ->rawColumns(['action_unreserve'])  /*  Define action buttons in storage spaces Datatable listing */
            ->editColumn('action_unreserve', function ($maintrans) {
                return '<a href="'.route('admin.childtranslist.deletetrans', $maintrans->id).'"
                class="btn btn-flat btn-danger" data-method="delete"
                data-trans-button-cancel="'.trans('buttons.general.cancel').'"
                data-trans-button-confirm="'.trans('buttons.general.crud.delete').'"
                data-trans-title="'.trans('strings.backend.general.are_you_sure').'">
                    <i data-toggle="tooltip" data-placement="top" title="Delete" class="fa fa-trash"></i>
            </a>';
            })
            /* ->addColumn('actions', function ($maintrans) {
                return $maintrans->action_buttons;
            }) */
            ->make(true);
    }
}
