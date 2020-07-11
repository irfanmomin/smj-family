<?php

namespace App\Http\Controllers\Backend\Family;

use App\Http\Controllers\Controller;
use App\Models\Family\Family;
use App\Repositories\Backend\Family\FamilyRepository;
use App\Http\Requests\Backend\Family\ManageFamilyRequest;
use App\Http\Requests\Backend\Family\CreateFamilyRequest;
use App\Http\Requests\Backend\Family\ManageMembersListRequest;
use App\Http\Requests\Backend\Family\EditFamilyRequest;
use App\Http\Requests\Backend\Family\DeleteFamilyRequest;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Responses\Backend\Family\EditResponse;

/**
 * Class FamilyController.
 */
class FamilyController extends Controller
{
    /**
     * @var FamilyRepository
     */
    protected $family;

    /**
     * @param \App\Repositories\Backend\Family\FamilyRepository $family
     */
    public function __construct(FamilyRepository $family)
    {
        $this->family = $family;
    }

    /**
     * @param \App\Http\Requests\Backend\Family\ManageFamilyRequest $request
     *
     * @return \App\Http\Responses\Backend\Family\IndexResponse
     */
    public function index(ManageFamilyRequest $request)
    {
        return new ViewResponse('backend.family.index');
    }

    /**
     * @param \App\Http\Requests\Backend\Family\CreateFamilyRequest $request
     *
     * @return mixed
     */
    public function create(CreateFamilyRequest $request)
    {
        // City List Array
        $cityList = getAllCityList();
        $cityListArray = array_combine($cityList, $cityList);
        // Area List Array
        $areaList = getAllAreaList('DHOLKA');
        $areaListArray = array_combine($areaList, $areaList);

        return view('backend.family.create')->with('cityList', $cityListArray)->with('areaList', $areaListArray);
    }

    /**
     * getAreaListAjax
     * Get Area list from City list
     * @param [type] $request
     * @return void
     */
    public function getAreaListAjax()
    {
        $cityName = $_REQUEST['cityName'];

        $areaListArray = [];

        if ($cityName != '') {
            // Area List Array
            $areaList = getAllAreaList($cityName);
            $areaListArray = array_combine($areaList, $areaList);
        }

        return response()->json($areaListArray);
    }

    /**
     * @param \App\Http\Requests\Backend\Family\CreateFamilyRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(CreateFamilyRequest $request)
    {
        $input = $request->except('_token');

        Validator::make($input, [
            'firstname' => 'required',
            'lastname'  => 'required',
            'surname'   => 'required',
            'gender'    => 'required',
            'mobile'    => 'required|numeric|gt:0',
            'dob'       => 'required|date|before_or_equal:' . date('Y-m-d'),
            'city'      => 'required',
            'area'      => 'required',

        ])->validate();

        $family = $this->family->create($input);

        if ($family == false) {
            session()->flash('flash_danger', trans('alerts.backend.family.wrong'));
            return redirect()->back();
        }

        $familyID = $family->id;

        if (isMainMember($family->id) == false) {
            $familyID = $family->family_id;
        }

        return new RedirectResponse(route('admin.family.editfamily', ['id' => $familyID]), ['flash_success' => trans('alerts.backend.family.inserted')]);

    }

    /**
     * editFamilyDetails function
     * This function is to edit Family Member details
     * @param [type] $familyID
     * @return void
     */
    public function editFamilyDetails($id = 0, EditFamilyRequest $request)
    {
        if ( isMainMember($id) == false ) {
            return new RedirectResponse(route('admin.family.index'), ['flash_danger' => trans('alerts.backend.family.wrongid')]);
        }

        $mainMemberArray = getMainMemberFullDetails($id);
        $childMembersArray = getChildMembersDetails($id);

        // City List Array
        $cityList = getAllCityList();
        $cityListArray = array_combine($cityList, $cityList);
        // Area List Array
        $areaList = getAllAreaList('DHOLKA');
        $areaListArray = array_combine($areaList, $areaList);

        return view('backend.family.editfamily')
            ->with('mainMemberArray', $mainMemberArray)
            ->with('childMembersArray', $childMembersArray)
            ->with('cityList', $cityListArray)
            ->with('areaList', $areaListArray);
    }

    /**
     * @param \App\Models\Family\Family                              $family
     * @param \App\Http\Requests\Backend\Family\EditFamilyRequest $request
     *
     * @return \App\Http\Responses\Backend\Family\EditResponse
     */
    public function edit(Family $family, EditFamilyRequest $request)
    {
        // City List Array
        $cityList = getAllCityList();
        $cityListArray = array_combine($cityList, $cityList);

        // Area List Array
        $city = isset($family->city) ? $family->city : 'DHOLKA';
        $areaList = getAllAreaList($city);
        $areaListArray = array_combine($areaList, $areaList);

        $isMainMember = isMainMember($family->id);

        $mainMemberArray = '';

        if (!$isMainMember && $family->family_id != NULL) {
            $mainMemberArray = getMainMemberFullDetails($family->family_id);
        }

        return new EditResponse($family, $cityListArray, $areaListArray, $isMainMember, $mainMemberArray);
    }

    /**
     * @param \App\Models\Family\Family                              $family
     * @param \App\Http\Requests\Backend\Family\EditFamilyRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(Family $family, EditFamilyRequest $request)
    {
        $input = $request->all();

        $this->family->update($family, $request->except(['_token', '_method']));

        $familyID = $family->id;

        if (isMainMember($family->id) == false) {
            $familyID = $family->family_id;
        }

        return new RedirectResponse(route('admin.family.editfamily', ['id' => $familyID]), ['flash_success' => trans('alerts.backend.family.updated')]);
    }

    /**
     * @param \App\Models\Family\Family                              $family
     * @param \App\Http\Requests\Backend\Family\DeleteFamilyRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Family $family, DeleteFamilyRequest $request)
    {
        $familyID = $family->id;

        if (isMainMember($family->id) == false) {
            $familyID = $family->family_id;
        }

        $this->family->delete($family);

        return new RedirectResponse(route('admin.family.editfamily', ['id' => $familyID]), ['flash_success' => trans('alerts.backend.family.deletedmember')]);
    }

    /**
     * deleteFullFamily function
     * Delete Full Family
     * @param [type] $id
     * @return void
     */
    public function deleteFullFamily($id)
    {
        // Get All Child members of the Family
        $childIDs = getChildMemberIDs($id);

        array_push($childIDs, (int) $id);

        // Delete All Child members of the Family
        if (isset($childIDs) && count($childIDs) > 0) {
            Family::destroy($childIDs);
        }

        return new RedirectResponse(route('admin.family.index'), ['flash_danger' => trans('alerts.backend.family.deleted')]);
    }

    /**
     * allMembersListIndex function
     * View All Members List page
     * @param ManageMembersListRequest $request
     * @return void
     */
    public function allMembersListIndex(ManageMembersListRequest $request)
    {
        return new ViewResponse('backend.family.allmembers');
    }
}
