<?php

namespace App\Http\Controllers\Backend\Family;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Family\ManageFamilyRequest;
use App\Repositories\Backend\Family\FamilyRepository;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class FamilyTableController.
 */
class FamilyTableController extends Controller
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
     * @param \App\Http\Requests\Backend\Family\ManageFamilyRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageFamilyRequest $request)
    {
        return Datatables::of($this->family->getForDataTable($request))
            ->escapeColumns(['id'])
            ->filterColumn('fullname', function($query, $keyword) {
                $query->whereRaw("firstname like ?", ["%$keyword%"])->orWhereRaw("lastname like ?", ["%$keyword%"])->orWhereRaw("surname like ?", ["%$keyword%"]);
            })
            ->filterColumn('areacity', function($query, $keyword) {
                $query->whereRaw("area like ?", ["%$keyword%"])->orWhereRaw("city like ?", ["%$keyword%"]);
            })
            ->addColumn('fullname', function ($family) {
                $childIDs = getChildMemberIDs($family->id);
                $totalMembers = 1;
                if (isset($childIDs) && count($childIDs) > 0) {
                    $totalMembers = count($childIDs) + 1;
                }

                return $family->fullname.' ('.$totalMembers.')';
            })
            /* ->addColumn('areacity', function ($family) {
                return $family->area.' / '.$family->city;
            }) */
            ->filterColumn('creatorName', function($query, $keyword) {
                $query->whereRaw("CONCAT(users.first_name, ' ', users.last_name) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('created_at', function ($family) {
                return date('d/m/Y h:i A', strtotime($family->created_at));
            })
            ->addColumn('actions', function ($family) {
                return $family->action_buttons;
            })
            ->make(true);
    }
}
