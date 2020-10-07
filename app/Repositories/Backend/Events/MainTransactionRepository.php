<?php

namespace App\Repositories\Backend\Events;

use App\Exceptions\GeneralException;
use App\Models\Events\MainTransaction;
use App\Repositories\BaseRepository;
use App\Models\Events\SubCategory;
use App\Models\Events\Transaction;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class MainTransactionRepository.
 */
class MainTransactionRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = MainTransaction::class;

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
            ->leftjoin(config('access.users_table'), config('access.users_table').'.id', '=', config("smj.tables.maintranstable").'.created_by')
            ->leftjoin(config('smj.tables.eventscategory'), config('smj.tables.eventscategory').'.id', '=', config("smj.tables.maintranstable").'.category_id')
            ->leftjoin(config('smj.tables.eventssubcategory'), config('smj.tables.eventssubcategory').'.id', '=', config("smj.tables.maintranstable").'.sub_category_id')
            ->leftjoin(config('smj.tables.eventsgroup'), config('smj.tables.eventsgroup').'.id', '=', config("smj.tables.eventssubcategory").'.event_group_id')
            ->select([
                DB::raw('CONCAT(users.first_name, " ", users.last_name) AS creatorName'),
                config('smj.tables.maintranstable').'.id',
                config('smj.tables.eventscategory').'.category_name',
                config('smj.tables.eventssubcategory').'.sub_category_name',
                config('smj.tables.eventsgroup').'.event_group_name',
                config('smj.tables.maintranstable').'.amount',
                config('smj.tables.maintranstable').'.created_at',
            ]);

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
    public function getForAllChildTransListDataTable($request = null)
    {
        $formData = NULL;
        $approveTypeFlg = 0;

        if (!is_null($request)) {
            $formData = $request->get('formData');
        }

        $columns = $request->request->get('columns');
        $id = $formData[0];
        $query =  Transaction::leftjoin(config('access.users_table'), config('access.users_table').'.id', '=', config("smj.tables.transtable").'.created_by')
        ->leftjoin(config('smj.tables.maintranstable'), config('smj.tables.maintranstable').'.id', '=', config("smj.tables.transtable").'.main_trans_id')
        ->leftjoin(config('smj.tables.pendingamount'), config('smj.tables.pendingamount').'.member_id', '=', config("smj.tables.transtable").'.member_id')
        ->leftjoin(config('smj.tables.eventssubcategory'), config('smj.tables.eventssubcategory').'.id', '=', config("smj.tables.maintranstable").'.sub_category_id')
        ->leftjoin(config('smj.tables.eventsgroup'), config('smj.tables.eventsgroup').'.id', '=', config("smj.tables.eventssubcategory").'.event_group_id')
        ->leftjoin(config('smj.tables.family'), config('smj.tables.family').'.id', '=', config("smj.tables.transtable").'.member_id')
        ->where(config('smj.tables.transtable').'.main_trans_id', $id)
        ->where(config('smj.tables.transtable').'.trans_type', 2)
        ->select([
            DB::raw('(SELECT COALESCE(SUM(t.amount),0) FROM smj_transactions t WHERE t.member_id=smj_transactions.member_id AND t.trans_type=1 AND t.main_trans_id=smj_transactions.main_trans_id) AS creditedTotalAmount'),
            DB::raw('(SELECT COALESCE(SUM(t.amount),0) FROM smj_transactions t WHERE t.member_id=smj_transactions.member_id AND t.trans_type=2 AND t.main_trans_id=smj_transactions.main_trans_id) AS debitedTotalAmount'),
            DB::raw('((SELECT COALESCE(SUM(t.amount),0) FROM smj_transactions t WHERE t.member_id=smj_transactions.member_id AND t.trans_type=2 AND t.main_trans_id=smj_transactions.main_trans_id) - (SELECT COALESCE(SUM(t.amount),0) FROM smj_transactions t WHERE t.member_id=smj_transactions.member_id AND t.trans_type=1 AND t.main_trans_id=smj_transactions.main_trans_id)) as trans_pending_amount'),
            DB::raw('CONCAT('.config("smj.tables.family").'.firstname, " ", '.config("smj.tables.family").'.lastname, " ", '.config("smj.tables.family").'.surname) AS member_name'),
            DB::raw('CONCAT('.config("smj.tables.family").'.area, " / ", '.config("smj.tables.family").'.city) AS areacity'),
            DB::raw('CONCAT(users.first_name, " ", users.last_name) AS creatorName'),
            config('smj.tables.transtable').'.id',
            config('smj.tables.transtable').'.member_id',
            config('smj.tables.family').'.main_family_id',
            config('smj.tables.transtable').'.trans_type',
            config('smj.tables.pendingamount').'.pending_amount',
            config('smj.tables.transtable').'.main_trans_id',
            config('smj.tables.eventssubcategory').'.sub_category_name',
            config('smj.tables.eventsgroup').'.event_group_name',
            config('smj.tables.maintranstable').'.amount',
            config('smj.tables.maintranstable').'.created_at',
        ])->groupBy(config('smj.tables.transtable').'.member_id');
           // dd($query->toSql());
        // If any Custom filter is applid
        if (! is_null($formData) && count($formData) > 2) {
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
     * @param array $input
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function create(array $input)
    {
        $maintransaction = self::MODEL;
        $maintransaction = new $maintransaction();

        $maintransaction->category_id     = $input['category_id'];
        $maintransaction->sub_category_id = $input['sub_category_id'];
        $maintransaction->amount          = $input['amount'];
        $maintransaction->created_by      = access()->user()->id;
        $maintransaction->created_at      = Carbon::now();

        if ($maintransaction->save()) {
            $incrID = $maintransaction->id;
            $subCategoryName = SubCategory::where('id', $maintransaction->sub_category_id)->value('sub_category_name');

            debitForAllCorrespondentMembers(
                $input['event_group_id'],
                $maintransaction->amount,
                $incrID,
                $subCategoryName);

            return $maintransaction;
        }

        return false;
    }

    /**
     * Update Sub Category.
     *
     * @param \App\Models\Events\Subcategory $subcategory
     * @param array                  $input
     */
    public function update(Subcategory $subcategory, array $input)
    {
        $input['updated_by'] = access()->user()->id;
        $input['updated_at'] = Carbon::now();

        if ( $subcategory->update($input) ) {
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
     * @param \App\Models\Events\MainTransaction $MainTransaction
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(MainTransaction $maintransaction)
    {
        DB::transaction(function () use ($maintransaction) {
            $mainTransID       = $maintransaction->id;
            $mainTransAmt      = $maintransaction->amount;
            $mainTransCatID    = $maintransaction->category_id;
            $mainTransSubCatID = $maintransaction->sub_category_id;

            $membersArr = Transaction::where('main_trans_id', $mainTransID)->pluck('member_id')->toArray();

            if ($maintransaction->delete()) {
                if (count($membersArr) > 0) {
                    Transaction::where('main_trans_id', $mainTransID)->delete();
                    foreach ($membersArr as $memberID) {
                        updatePendingAmount($memberID, $mainTransAmt, 'credited');
                    }
                }

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
     * @param array $input
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function creditPayment(array $input)
    {
        $memberID = decryptMethod($input['member_id']);

        $transactionDate = $input['date_']['year'].'-'.$input['date_']['month'].'-'.$input['date_']['day'];

        creditTransaction($memberID, $input['amount'], $input['main_trans_id'], $input['note'], $input['receipt_no'], $transactionDate);

        return true;
    }
}
