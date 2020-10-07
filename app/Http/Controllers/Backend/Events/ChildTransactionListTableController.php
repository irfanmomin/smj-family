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
            /* ->filterColumn('pending_amount', function($query, $keyword) {
                if ($keyword == "1") {
                } else if ($keyword == "2") {
                    $query->whereRaw("((SELECT COALESCE(SUM(t.amount),0) FROM smj_transactions t WHERE t.member_id=smj_transactions.member_id AND t.trans_type=2 AND t.main_trans_id=smj_transactions.main_trans_id) - (SELECT COALESCE(SUM(t.amount),0) FROM smj_transactions t WHERE t.member_id=smj_transactions.member_id AND t.trans_type=1 AND t.main_trans_id=smj_transactions.main_trans_id)) > 0 ");
                } else if ($keyword == "3") {
                    $query->whereRaw("((SELECT COALESCE(SUM(t.amount),0) FROM smj_transactions t WHERE t.member_id=smj_transactions.member_id AND t.trans_type=2 AND t.main_trans_id=smj_transactions.main_trans_id) - (SELECT COALESCE(SUM(t.amount),0) FROM smj_transactions t WHERE t.member_id=smj_transactions.member_id AND t.trans_type=1 AND t.main_trans_id=smj_transactions.main_trans_id)) <= 0 ");
                }
            }) */
            ->filterColumn('pending_amount_hidden', function($query, $keyword) {
                if ($keyword == "1") {
                } else if ($keyword == "2") {
                    $query->whereRaw("((SELECT COALESCE(SUM(t.amount),0) FROM smj_transactions t WHERE t.member_id=smj_transactions.member_id AND t.trans_type=2 AND t.main_trans_id=smj_transactions.main_trans_id) - (SELECT COALESCE(SUM(t.amount),0) FROM smj_transactions t WHERE t.member_id=smj_transactions.member_id AND t.trans_type=1 AND t.main_trans_id=smj_transactions.main_trans_id)) > 0 ");
                } else if ($keyword == "3") {
                    $query->whereRaw("((SELECT COALESCE(SUM(t.amount),0) FROM smj_transactions t WHERE t.member_id=smj_transactions.member_id AND t.trans_type=2 AND t.main_trans_id=smj_transactions.main_trans_id) - (SELECT COALESCE(SUM(t.amount),0) FROM smj_transactions t WHERE t.member_id=smj_transactions.member_id AND t.trans_type=1 AND t.main_trans_id=smj_transactions.main_trans_id)) <= 0 ");
                }
            })
            ->filterColumn('areacity', function($query, $keyword) {
                $query->whereRaw("area like ?", ["%$keyword%"])->orWhereRaw("city like ?", ["%$keyword%"]);
            })
            ->addColumn('action_unreserve', function ($maintrans) {
                return '<a href="javascript:void(0);" data-id="'.encryptMethod($maintrans->id).'"
                class="btn btn-flat btn-danger dlt-debited-trans">
                <i data-toggle="tooltip" data-placement="top" title="Delete" class="fa fa-trash"></i>
                </a>    <a class="btn btn-success btn-flat btn-credit-payment-modal btn-mem-'.$maintrans->member_id.'" href="'.route('admin.family.addpaymentmodal', $maintrans->member_id).'" data-toggle="modal" data-target="#convertedInfoModal"><i data-toggle="tooltip" data-placement="top" title="Add Payment" class="fa fa-money"></i></a>';
            })
            ->rawColumns(['action_unreserve'])  /*  Define action buttons in storage spaces Datatable listing */
            /* ->addColumn('pending_amount', function ($family) {
                // $creditedTotalAmount = Transaction::where('member_id', $family->member_id)->where('trans_type', '1')->where('main_trans_id', $family->main_trans_id)->sum('amount');

                // $debitedTotalAmount = Transaction::where('member_id', $family->member_id)->where('trans_type', '2')->where('main_trans_id', $family->main_trans_id)->sum('amount');

                // $newPendingAmount = (floatval($debitedTotalAmount)-floatval($creditedTotalAmount));
                // $newPendingAmount = number_format((float)$newPendingAmount, 2, '.', '');

                return '<h4><span class="label label-warning">&#x20B9; '.($family->trans_pending_amount).'</span></h4>';
            }) */
            ->addColumn('pending_amount_hidden', function ($family) {
                return '<h4><span class="label label-warning">&#x20B9; '.($family->trans_pending_amount).'</span></h4>';
            })
            ->make(true);
    }
}
