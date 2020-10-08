<?php

namespace App\Repositories\Backend\Family;

use App\Exceptions\GeneralException;
use App\Models\Family\Family;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use DB;
use App\Models\Events\Transaction;
use App\Models\Events\MainTransaction;
use App\Models\Events\PendingAmount;
use Illuminate\Support\Facades\Storage;

/**
 * Class FamilyRepository.
 */
class FamilyRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Family::class;

    protected $upload_path;

    /**
     * Storage Class Object.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    protected $storage;

    public function __construct()
    {
        $this->upload_path = 'img'.DIRECTORY_SEPARATOR.'blog'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }

    /**
     * @return mixed
     */
    public function getForDataTable($request = null)
    {
        $formData = NULL;
        $approveTypeFlg = 0;

        if (!is_null($request)) {
            $formData = $request->get('formData');
        }

        $columns = $request->request->get('columns');

        $query =  $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table').'.id', '=', config("smj.tables.family").'.created_by')
            ->select([
                DB::raw('CONCAT('.config("smj.tables.family").'.firstname, " ", '.config("smj.tables.family").'.lastname, " ", '.config("smj.tables.family").'.surname) AS fullname'),
                DB::raw('CONCAT('.config("smj.tables.family").'.area, " / ", '.config("smj.tables.family").'.city) AS areacity'),
                DB::raw('CONCAT(users.first_name, " ", users.last_name) AS creatorName'),
                config('smj.tables.family').'.id',
                config('smj.tables.family').'.family_id',
                config('smj.tables.family').'.firstname',
                config('smj.tables.family').'.lastname',
                config('smj.tables.family').'.main_family_id',
                config('smj.tables.family').'.surname',
                config('smj.tables.family').'.area',
                config('smj.tables.family').'.city',
                config('smj.tables.family').'.is_verified',
                config('smj.tables.family').'.created_at',
            ])->where(config('smj.tables.family').'.is_main', 1)
            ->whereNull(config('smj.tables.family').'.family_id');

        if (!access()->allow('view-all-members-list')) {
            $query->where(config('smj.tables.family').'.created_by', access()->user()->id);
        }

        // If any Custom filter is applid
        if (! is_null($formData) && count($formData) > 0) {
            $arrRequest = [];

            // Make Structured Filters Data
            foreach ($formData as $data) {
                if ( $data['name'] == 'verifyfilter' ) {
                    $arrRequest[$data['name']] = $data['value'];
                }
            }

            if (
                count($arrRequest) > 0 &&
                isset($arrRequest['verifyfilter']) &&
                !empty($arrRequest['verifyfilter']) &&
                ($arrRequest['verifyfilter'] == 'verified' || $arrRequest['verifyfilter'] == 'unverified')
            ) {
                // Verified Non verified Filter
                if ($arrRequest['verifyfilter'] == 'verified') {
                    $query = $query->where(config('smj.tables.family').'.is_verified', 1);
                } else if ($arrRequest['verifyfilter'] == 'unverified') {
                    $query = $query->where(config('smj.tables.family').'.is_verified', 0);
                }
            } else {
                return $query;
            }
        }

        return $query;
    }

    /**
     * @return mixed
     */
    public function getForAllMembersListDataTable($request = null)
    {
        $formData = NULL;
        $approveTypeFlg = 0;

        if (!is_null($request)) {
            $formData = $request->get('formData');
        }

        $columns = $request->request->get('columns');

        $query =  $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table').'.id', '=', config("smj.tables.family").'.created_by')
            ->leftjoin(config('smj.tables.pendingamount'), config('smj.tables.pendingamount').'.member_id', '=', config("smj.tables.family").'.id')
            ->select([
                DB::raw('CONCAT('.config("smj.tables.family").'.firstname, " ", '.config("smj.tables.family").'.lastname, " ", '.config("smj.tables.family").'.surname) AS fullname'),
                DB::raw('CONCAT('.config("smj.tables.family").'.area, " / ", '.config("smj.tables.family").'.city) AS areacity'),
                DB::raw('CONCAT(users.first_name, " ", users.last_name) AS creatorName'),
                config('smj.tables.family').'.id',
                config('smj.tables.family').'.family_id',
                config('smj.tables.pendingamount').'.pending_amount',
                config('smj.tables.pendingamount').'.pending_amount as pending_amount_hidden',
                config('smj.tables.family').'.firstname',
                config('smj.tables.family').'.lastname',
                config('smj.tables.family').'.surname',
                config('smj.tables.family').'.dob',
                config('smj.tables.family').'.main_family_id',
                config('smj.tables.family').'.is_main',
                config('smj.tables.family').'.area',
                config('smj.tables.family').'.city',
                config('smj.tables.family').'.is_verified',
                config('smj.tables.family').'.created_at',
            ]);

        // If any Custom filter is applid
        if (! is_null($formData) && count($formData) > 0) {
            $arrRequest = [];

            // Make Structured Filters Data
            foreach ($formData as $data) {
                if ( $data['name'] == 'verifiedstatus' ) {
                    $arrRequest[$data['name']] = $data['value'];
                }
            }

            if (
                count($arrRequest) > 0 &&
                isset($arrRequest['verifiedstatus']) &&
                !empty($arrRequest['verifiedstatus']) &&
                ($arrRequest['verifiedstatus'] == 'verified' || $arrRequest['verifiedstatus'] == 'unverified')
            ) {
                // Verified Non verified Filter
                if ($arrRequest['verifiedstatus'] == 'verified') {
                    $query = $query->where(config('smj.tables.family').'.is_verified', 1);
                } else if ($arrRequest['verifiedstatus'] == 'unverified') {
                    $query = $query->where(config('smj.tables.family').'.is_verified', 0);
                }
            } else {
                return $query;
            }
        }

        return $query;
    }

    /**
     * @param array $input
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function create(array $input)
    {
        $family = self::MODEL;
        $family = new $family();

        $relationValue = isset($input['relation']) ? $input['relation']  : 'Self';
        $familyIDValue   = isset($input['family_id']) ? $input['family_id']: NULL;

        $family->dob = $input['dob'];
        $family->area = $input['area'];
        $family->city = $input['city'];
        $family->mobile = $input['mobile'];
        $family->gender = $input['gender'];
        $family->surname = $input['surname'];
        $family->lastname = $input['lastname'];
        $family->firstname = $input['firstname'];
        $family->relation = $relationValue;
        $family->is_main = isset($input['is_main']) ? $input['is_main'] : '1';
        $family->family_id = $familyIDValue;
        $family->aadhar_id = isset($input['aadhar_id']) ? $input['aadhar_id'] : NULL;
        $family->election_id = isset($input['election_id']) ? $input['election_id'] : NULL;
        $family->education = isset($input['education']) ? $input['education'] : NULL;
        $family->occupation = isset($input['occupation']) ? $input['occupation'] : NULL;
        $family->created_by = access()->user()->id;
        $family->created_at = Carbon::now();
        $family->updated_at = NULL;

        if ($relationValue == 'Self' && $familyIDValue == NULL) {
            $maxID = Family::withTrashed()->max('main_family_id');

            $family->main_family_id = ($maxID+1);
        } else {
            $mainFAMILYID = Family::where('id', $familyIDValue)->value('main_family_id');
            if ($mainFAMILYID > 0 && is_numeric($mainFAMILYID)) {
                $family->main_family_id = $mainFAMILYID;
            } else {
                return false;
            }
        }

        if ($family->save()) {
            return $family;
        }

        return false;
    }

    /**
     * Update Family.
     *
     * @param \App\Models\Family\Family $Family
     * @param array                  $input
     */
    public function update(Family $family, array $input)
    {
        $input['dob'] = $input['date_']['year'].'-'.$input['date_']['month'].'-'.$input['date_']['day'];
        $input['updated_by'] = access()->user()->id;

        if (!access()->allow('view-all-members-list')) {
            $input['is_verified'] = 0;
            if ( !isMainMember($family->id) ) {
                $mainMemberID = getMainMemberID($family->id);
                if ($mainMemberID != null) {
                    $updateMain = Family::findorfail($mainMemberID);
                    $updateMain->is_verified = 0;
                    $updateMain->updated_by = access()->user()->id;
                    $updateMain->save();
                }
            }
        }

        $mainMemberOldMobile = $family->mobile;

        if ( $family->update($input) ) {
            $childIDs = getChildMemberIDs($family->id);

            if (isset($childIDs) && count($childIDs) > 0) {
                foreach ($childIDs as $memberID) {
                    $innerMember = Family::where('id', $memberID)->get()->first();
                    $innerMember->surname = $input['surname'];
                    $innerMember->area = $input['area'];
                    $innerMember->city = $input['city'];

                    // Update Mobile Number if used in Child member
                    if ( $innerMember->mobile == $mainMemberOldMobile ) {
                        $innerMember->mobile = $input['mobile'];
                    }

                    $innerMember->save();
                }
            }

            return true;
        }

        return false;
    }

    /**
     * Creating Tags.
     *
     * @param array $tags
     *
     * @return array
     */
    public function createTags($tags)
    {
        //Creating a new array for tags (newly created)
        $tags_array = [];

        foreach ($tags as $tag) {
            if (is_numeric($tag)) {
                $tags_array[] = $tag;
            } else {
                $newTag = BlogTag::create(['name' => $tag, 'status' => 1, 'created_by' => 1]);
                $tags_array[] = $newTag->id;
            }
        }

        return $tags_array;
    }

    /**
     * Creating Categories.
     *
     * @param Array($categories)
     *
     * @return array
     */
    public function createCategories($categories)
    {
        //Creating a new array for categories (newly created)
        $categories_array = [];

        foreach ($categories as $category) {
            if (is_numeric($category)) {
                $categories_array[] = $category;
            } else {
                $newCategory = BlogCategory::create(['name' => $category, 'status' => 1, 'created_by' => 1]);

                $categories_array[] = $newCategory->id;
            }
        }

        return $categories_array;
    }

    /**
     * @param \App\Models\Family\Family $family
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(Family $family)
    {
        DB::transaction(function () use ($family) {
            if ($family->delete()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.blogs.delete_error'));
        });
    }

    /**
     * Upload Image.
     *
     * @param array $input
     *
     * @return array $input
     */
    public function uploadImage($input)
    {
        $avatar = $input['featured_image'];

        if (isset($input['featured_image']) && !empty($input['featured_image'])) {
            $fileName = time().$avatar->getClientOriginalName();

            $this->storage->put($this->upload_path.$fileName, file_get_contents($avatar->getRealPath()));

            $input = array_merge($input, ['featured_image' => $fileName]);

            return $input;
        }
    }

    /**
     * Destroy Old Image.
     *
     * @param int $id
     */
    public function deleteOldFile($model)
    {
        $fileName = $model->featured_image;

        return $this->storage->delete($this->upload_path.$fileName);
    }

    /**
     * getTransModalDetails.
     *
     * @param int $id
     */
    public function getTransModalDetails($memberID)
    {
        $memberDetails = Family::where('id', $memberID)->get()->first();
        $finalArray = [];

        if (!is_null($memberDetails)) {
            $transHistoryArray = getTransHistoryUsingMemberID($memberID);
            $memberPendingAmount = PendingAmount::where('member_id', $memberID)->value('pending_amount');
            $eventsList = MainTransaction::leftjoin(config('smj.tables.eventssubcategory'), config('smj.tables.eventssubcategory').'.id', '=', config("smj.tables.maintranstable").'.sub_category_id')
            ->pluck(config('smj.tables.eventssubcategory').'.sub_category_name', config('smj.tables.maintranstable').'.id')->toArray();

            $finalArray['transaction_history_array'] = $transHistoryArray;
            $finalArray['total_pending_amount']      = $memberPendingAmount;
            $finalArray['events_list']               = $eventsList;
        }

        return $finalArray;
    }
}
