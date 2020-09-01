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
use Carbon\Carbon;

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

        $validatedData = $request->validate([
            'firstname' => 'required',
            'lastname'  => 'required',
            'surname'   => 'required',
            'gender'    => 'required',
            'mobile'    => 'required|numeric|gt:0',
            'dob'       => 'required|date|before_or_equal:' . date('Y-m-d'),
            'city'      => 'required',
            'area'      => 'required',
            'election_id'      => 'required_if:doc_type,election|max:255',
        ]);

        if ( $input['election_id'] == null && $input['aadhar_id'] != '0000-0000-0000' ) {
            $validatedData = $request->validate([
               /*  'aadhar_id'      => 'required_if:doc_type,aadhar|unique:members|max:14', */
                'aadhar_id'      => 'required_if:doc_type,aadhar|unique:members,aadhar_id,NULL,id,deleted_at,NULL|max:14',
            ]);
        }

        $input = $request->except('_token', 'doc_type');

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
        if (access()->user()->id == Family::findorfail($id)->created_by || access()->allow('view-all-members-list')) {
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

        return new RedirectResponse(route('admin.family.index'), ['flash_danger' => 'You are not allowed to See this page']);
    }

    /**
     * @param \App\Models\Family\Family                              $family
     * @param \App\Http\Requests\Backend\Family\EditFamilyRequest $request
     *
     * @return \App\Http\Responses\Backend\Family\EditResponse
     */
    public function edit(Family $family, EditFamilyRequest $request)
    {
        if (access()->user()->id == $family->created_by || access()->allow('view-all-members-list')) {
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

        return new RedirectResponse(route('admin.family.index'), ['flash_danger' => 'You are not allowed to edit Other\'s details.']);
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

        $validatedData = $request->validate([
            'firstname' => 'required',
            'lastname'  => 'required',
            'gender'    => 'required',
            'mobile'    => 'required|numeric|gt:0',
            'dob'       => 'required|date|before_or_equal:' . date('Y-m-d'),
            'election_id'      => 'required_if:doc_type,election|max:255',
        ]);

        if ($request->get('election_id') == null && $request->get('aadhar_id') != '0000-0000-0000') {
            $validatedData = $request->validate([
                'aadhar_id'      => 'required_if:doc_type,aadhar|max:14|unique:members,aadhar_id,'.$family->id.',id,deleted_at,NULL',
                /* 'aadhar_id'      => 'required_if:doc_type,aadhar|unique:members,aadhar_id,NULL,id, */
            ]);
        }

        $this->family->update($family, $request->except(['_token', '_method', 'doc_type']));

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
        if (access()->user()->id == $family->created_by || access()->allow('view-all-members-list')) {
            $familyID = $family->id;

            if (isMainMember($family->id) == false) {
                $familyID = $family->family_id;
            }

            $this->family->delete($family);

            return new RedirectResponse(route('admin.family.editfamily', ['id' => $familyID]), ['flash_success' => trans('alerts.backend.family.deletedmember')]);
        }

        return new RedirectResponse(route('admin.family.index'), ['flash_danger' => 'You are not allowed to delete this member.']);
    }

    /**
     * deleteFullFamily function
     * Delete Full Family
     * @param [type] $id
     * @return void
     */
    public function deleteFullFamily($id)
    {
        if (access()->user()->id == Family::findorfail($id)->created_by || access()->allow('view-all-members-list')) {
            // Get All Child members of the Family
            $childIDs = getChildMemberIDs($id);

            array_push($childIDs, (int) $id);

            // Delete All Child members of the Family
            if (isset($childIDs) && count($childIDs) > 0) {
                Family::destroy($childIDs);
            }

            return new RedirectResponse(route('admin.family.index'), ['flash_danger' => trans('alerts.backend.family.deleted')]);
        }

        return new RedirectResponse(route('admin.family.index'), ['flash_danger' => 'You are not allowed to delete this Family.']);
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

    /**
     * verifyMember function
     * Verify Member
     * @param [type] $id
     * @return void
     */
    public function verifyMember($id)
    {
        if (access()->allow('view-all-members-list')) {

            if (isMainMember($id) == true) {
                $childIDs = getChildMemberIDs($id);

                if (count($childIDs) > 0) {
                    $allVerified = checkAllChildVerified($childIDs);

                    if (!$allVerified) {
                        return redirect()->back()->withInput()->withFlashWarning('Please verify all Family members first!');
                    }
                }
            }

            $family = Family::findorfail($id);
            $family->is_verified = '1';
            $family->updated_by = access()->user()->id;
            $family->verified_by = access()->user()->id;
            $family->save();

            return redirect()->back()->withInput()->withFlashSuccess('Verified Successfully!');
        }

        return redirect()->back()->withInput()->withFlashWarning('You are not allowed to Verify / Unverify');
    }

    /**
     * unVerifyMember function
     * Unverify Member
     * @param [type] $id
     * @return void
     */
    public function unVerifyMember($id)
    {
        if (access()->allow('view-all-members-list')) {
            $family = Family::findorfail($id);
            $family->is_verified = 0;
            $family->updated_by = access()->user()->id;
            $family->save();

            return redirect()->back()->withInput()->withFlashWarning('UnVerified Successfully!');
        }

        return redirect()->back()->withInput()->withFlashWarning('You are not allowed to Verify / Unverify');
    }

    /**
     * storeMemberExpired Store expired member date and delete it
     * @param \App\Models\Family\Family                              $family
     * @param \App\Http\Requests\Backend\Family\EditFamilyRequest $request
     *
     * @return \App\Http\Responses\Backend\Family\EditResponse
     */
    public function storeMemberExpired(EditFamilyRequest $request)
    {
        $validatedData = $request->validate([
            "date_of_death"     => "required|date",
            "hdn-exp-member-id" => "required|numeric"
        ]);

        $input = $request->except('_token');

        if ( is_numeric($input['hdn-exp-member-id']) && !isMainMember($input['hdn-exp-member-id'])) {
            $id = $input['hdn-exp-member-id'];
            $dateOfExpired = $input['date_of_death'];

            $expireMember = Family::findorfail($id);
            $expireMember->expired_date = $dateOfExpired;
            $expireMember->updated_at = Carbon::now();
            $expireMember->updated_by = access()->user()->id;

            $mainID = getMainMemberID($id);

            if ($expireMember->save()) {
                Family::destroy([$id]);
            }

            return new RedirectResponse(route('admin.family.editfamily', ['id' => $mainID]), ['flash_success' => trans('alerts.backend.family.recordupdated')]);
        }

        return redirect()->back()->withInput()->withFlashWarning('This member is a Main member, Could not delete this');
    }



    /**
     * @param \App\Models\Family\Family                              $family
     * @param \App\Http\Requests\Backend\Family\EditFamilyRequest $request
     *
     * @return \App\Http\Responses\Backend\Family\EditResponse
     */
    public function mainMemberExpired($id)
    {
        if (isMainMember($id)) {

            $childIDs = getChildMemberIDs($id);

            if (count($childIDs) <= 0) {
                $expireMainMember = Family::findorfail($id);
                $expireMainMember->expired_date = Carbon::now();
                $expireMainMember->updated_at   = Carbon::now();
                $expireMainMember->updated_by   = access()->user()->id;
                $expireMainMember->save();

                Family::destroy([$id]);

                return new RedirectResponse(route('admin.family.index'), ['flash_success' => 'Record Updated Successfully']);
            }

            $mainMemberArray = Family::findorfail($id);
            $childMembersArray = getChildMembersDetails($id);

            return view('backend.family.selectmainmember')
                ->with('mainMemberArray', $mainMemberArray)
                ->with('childMembersArray', $childMembersArray);
        }

        return redirect()->back()->withInput()->withFlashWarning('This member is not a Main member');
    }

    /**
     * Store new Relation / Main member And Delete the expired member
     * @param \App\Http\Requests\Backend\Family\storeNewRelationAndDelete $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function storeNewRelationAndDelete(EditFamilyRequest $request)
    {
        $input = $request->except('_token');

        $validatedData = $request->validate([
            'newmainmember' => 'required',
            'expiredmember' => 'required',
            'date_of_death' => 'required',
            'mobile'        => 'required',
        ]);

        $numberUpdated = false;

        // Set expired date today for member
        if ($input['expiredmember'] != NULL && is_numeric($input['expiredmember'])) {
            $expireMainMember = Family::findorfail($input['expiredmember']);
            $expireMainMember->expired_date = $input['date_of_death'];
            $expireMainMember->updated_at   = Carbon::now();
            $expireMainMember->updated_by   = access()->user()->id;

            // Assign new Main member
            if ($expireMainMember->save()) {
                $newMainMember = Family::findorfail($input['newmainmember']);
                $newMainMember->is_main   = 1;
                $newMainMember->family_id = null;
                $mainMemberOldMobile      = $expireMainMember->mobile;

                if ( $input['mobile'] != $mainMemberOldMobile ) {
                    $numberUpdated = true;
                    $newMainMember->mobile = $input['mobile'];
                }

                $newMainMember->relation   = 'Self';
                $newMainMember->updated_at = Carbon::now();
                $newMainMember->updated_by = access()->user()->id;

                // Save and set expired member as deleted
                if ($newMainMember->save()) {
                    $expireMainMember->family_id = $input['newmainmember'];
                    $expireMainMember->save();
                    Family::destroy([$input['expiredmember']]);
                } else {
                    return redirect()->back()->withInput()->withFlashWarning('Something went Wrong! Couldn\'t save new member.');
                }
            }
        }

        $RelationsArray = $request->except('_token', 'expiredmember', 'newmainmember');

        // Set Child Members Relation and set Family Main member
        foreach ($RelationsArray as $key => $relation) {
            if (strpos($key, 'relation_') !== false) {
                $idAndLabel = explode("_", $key);

                if ( is_numeric($idAndLabel[1]) && $relation != NULL ) {
                    $childMembers = Family::findorfail($idAndLabel[1]);
                    $childMembers->relation = $relation;

                    // Only if Expired member's mobile number is stored
                    if ($numberUpdated && $mainMemberOldMobile == $childMembers->mobile) {
                        $childMembers->mobile = $input['mobile'];
                    }

                    $childMembers->updated_at = Carbon::now();
                    $childMembers->family_id  = $input['newmainmember'];
                    $childMembers->updated_by = access()->user()->id;
                    $childMembers->save();
                }
            }
        }

        // Return to main page with Updated Details
        return new RedirectResponse(route('admin.family.editfamily', ['id' => $input['newmainmember']]), ['flash_success' => trans('alerts.backend.family.newmemberassigned')]);

    }
}
