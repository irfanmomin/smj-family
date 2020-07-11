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
            ->addColumn('fullname', function ($family) {
                return $family->fullname;
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
                    return '<span class="label label-default">NO</span>';
                } else {
                    return '-';
                }
            })
            ->addColumn('actions', function ($family) {
                return $family->action_buttons;
            })
            ->make(true);
    }
}
