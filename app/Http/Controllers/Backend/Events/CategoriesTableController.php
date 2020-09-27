<?php

namespace App\Http\Controllers\Backend\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Events\ManageCategoryRequest;
use App\Repositories\Backend\Events\SubCategoryRepository;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class CategoriesTableController.
 */
class CategoriesTableController extends Controller
{
    protected $subcategory;

    /**
     * @param \App\Repositories\Backend\Events\SubCategoryRepository $cmspages
     */
    public function __construct(SubCategoryRepository $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    /**
     * @param \App\Http\Requests\Backend\Events\ManageCategoryRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageCategoryRequest $request)
    {
        return Datatables::of($this->subcategory->getForDataTable($request))
            ->escapeColumns(['id'])
            /* ->filterColumn('fullname', function($query, $keyword) {
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
            ->addColumn('is_verified', function ($family) {
                if ($family->is_verified == 1) {
                    return '';
                } else if ($family->is_verified == 0) {
                    return '<span class="label label-danger">Not Verified</span>';
                } else {
                    return '-';
                }
            })
            ->filterColumn('creatorName', function($query, $keyword) {
                $query->whereRaw("CONCAT(users.first_name, ' ', users.last_name) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('created_at', function ($family) {
                return date('d/m/Y h:i A', strtotime($family->created_at));
            }) */
            ->addColumn('actions', function ($subcategory) {
                return $subcategory->action_buttons;
            })
            ->make(true);
    }
}
