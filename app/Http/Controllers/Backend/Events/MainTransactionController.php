<?php

namespace App\Http\Controllers\Backend\Events;

use App\Http\Controllers\Controller;
use App\Models\Events\Transaction;
use App\Models\Events\SubCategory;
use App\Models\Events\MainTransaction;
use App\Repositories\Backend\Events\SubCategoryRepository;
use App\Repositories\Backend\Events\MainTransactionRepository;
use App\Http\Requests\Backend\Events\ManageMainTransactionRequest;
use App\Http\Requests\Backend\Events\CreateMainTransactionRequest;
use App\Http\Requests\Backend\Events\EditMainTransactionRequest;
use App\Http\Requests\Backend\Events\DeleteMainTransactionRequest;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Responses\Backend\Events\SubCategories\EditResponse;
use Carbon\Carbon;
use DB;

/**
 * Class MainTransactionController.
 */
class MainTransactionController extends Controller
{
    /**
     * @var MainTransactionRepository
     */
    protected $maintransaction;

    /**
     * @param \App\Repositories\Backend\Events\MainTransactionRepository $category
     */
    public function __construct(MainTransactionRepository $maintransaction)
    {
        $this->maintransaction = $maintransaction;
    }

    /**
     * @param \App\Http\Requests\Backend\Family\ManageMainTransactionRequest $request
     *
     * @return \App\Http\Responses\Backend\Family\IndexResponse
     */
    public function index(ManageMainTransactionRequest $request)
    {
        return new ViewResponse('backend.events.eventmaintransactions.index');
    }

    /**
     * @param \App\Http\Requests\Backend\Events\CreateMainTransactionRequest $request
     *
     * @return mixed
     */
    public function create(CreateMainTransactionRequest $request)
    {
        // MainEventCategoriesList Array
        $mainEventCategoriesList = getMainEventCategoriesList();

        return view('backend.events.eventmaintransactions.create')->with('mainEventCategoriesList', $mainEventCategoriesList);
    }

    /**
     * @param \App\Http\Requests\Backend\Events\CreateMainTransactionRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(CreateMainTransactionRequest $request)
    {
        $input = $request->except('_token');

        $validatedData = $request->validate([
            'category_id'     => 'required',
            'sub_category_id' => 'required',
            'amount'          =>  ['required','regex: /^\$?[0-9]?((\.[0-9]+)|([0-9]+(\.[0-9]+)?))$/'],
        ]);

        $maintransaction = $this->maintransaction->create($input);

        if ($maintransaction == false) {
            session()->flash('flash_danger', trans('alerts.backend.family.wrong'));
            return redirect()->back();
        }

        return new RedirectResponse(route('admin.maintransactions.showchildtranslist', ['id' => $maintransaction]), ['flash_success' => trans('alerts.backend.eventmaintrans.inserted')]);
    }

    /**
     * @param \App\Models\Events\MainTransaction                              $maintransaction
     * @param \App\Http\Requests\Backend\Family\EditMainTransactionRequest $request
     *
     * @return \App\Http\Responses\Backend\Family\EditResponse
     */
    public function edit(MainTransaction $maintransaction, EditMainTransactionRequest $request)
    {
        // MainEventCategoriesList Array
        $mainEventCategoriesList = getMainEventCategoriesList();
        $getEventGroupsList      = getEventGroupsList();

        return new EditResponse($maintransaction, $mainEventCategoriesList, $getEventGroupsList);
    }

    /**
     * @param \App\Models\Events\MainTransaction                              $maintransaction
     * @param \App\Http\Requests\Backend\Events\EditMainTransactionRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(MainTransaction $maintransaction, EditMainTransactionRequest $request)
    {
        $input = $request->all();

        $validatedData = $request->validate([
            'sub_category_name' => 'required',
            'category_id'       => 'required',
            'event_group_id'    => 'required',
        ]);

        $this->maintransaction->update($maintransaction, $request->except(['_token', '_method']));

        return new RedirectResponse(route('admin.maintransactions.index'), ['flash_success' => trans('alerts.backend.events.updated')]);
    }

    /**
     * @param \App\Models\Events\MainTransaction                              $maintransaction
     * @param \App\Http\Requests\Backend\Family\DeleteMainTransactionRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(MainTransaction $maintransaction, DeleteMainTransactionRequest $request)
    {
        $this->maintransaction->delete($maintransaction);

        return new RedirectResponse(route('admin.maintransactions.index'), ['flash_success' => trans('alerts.backend.eventmaintrans.deleted')]);
    }

    /**
     * getSubCategoryList
     * Get Sub Category List
     * @param [type] $request
     * @return void
     */
    public function getSubCategoryList() {
        $categoryID = $_REQUEST['categoryID'];

        $mixArray = [];

        if ($categoryID != '') {
            // Sub Category List
            $subCategoryListFull = getsubCategoryList($categoryID);

            $existingSubCategories = MainTransaction::where('category_id', $categoryID)->pluck('sub_category_id')->toArray();
            $subCategoryList = [];

            foreach ($subCategoryListFull as $subCategory) {
                if (!in_array($subCategory['id'], $existingSubCategories)) {
                    $subCategoryList[] = $subCategory;
                }
            }

            if (count($subCategoryList) > 0) {
                foreach ($subCategoryList as $subCategoryDetails) {
                    $subCategoryArray[$subCategoryDetails['id']] = $subCategoryDetails['sub_category_name'];
                    $eventGroup = $subCategoryDetails['event_group_name'];
                    $eventGroupID = $subCategoryDetails['event_group_id'];
                }

                $mixArray[] = $subCategoryArray;
                $mixArray[] = $eventGroup;
                $mixArray[] = $eventGroupID;
            }

        }

        return response()->json($mixArray);
    }

    /**
     * @param \App\Http\Requests\Backend\Events\ManageMainTransactionRequest $request
     *
     * @return mixed
     */
    public function showChildTrans($id = 0, ManageMainTransactionRequest $request)
    {
        if ($id > 0) {

            $query =  Transaction::leftjoin(config('smj.tables.maintranstable'), config('smj.tables.maintranstable').'.id', '=', config("smj.tables.transtable").'.main_trans_id')
                ->leftjoin(config('smj.tables.eventssubcategory'), config('smj.tables.eventssubcategory').'.id', '=', config("smj.tables.maintranstable").'.sub_category_id')
                ->where(config('smj.tables.transtable').'.main_trans_id', $id)
                ->select([
                    config('smj.tables.eventssubcategory').'.sub_category_name',
                    config('smj.tables.maintranstable').'.amount',
                ]);

            $mainTransDetails = $query->first();

            if ($mainTransDetails == null) {
                return new RedirectResponse(route('admin.maintransactions.index'), ['flash_danger' => 'Child Transactions not found for this Main Transaction']);
            }

            //->toArray()
            return view('backend.events.eventmaintransactions.childtranslist')->with('id', $id)->with('mainTransDetails', $mainTransDetails->toArray());
        }

        return new RedirectResponse(route('admin.maintransactions.index'), ['flash_danger' => 'Child Transactions not found for this Main Transaction']);

    }

    public function deleteChildTransaction(ManageMainTransactionRequest $request) {
        $id = decryptMethod($request->get('id'));
        $trans = Transaction::where('id', $id);
        $transDetails = $trans->get()->toArray();

        \Log::info('Deleted Trans start');
        \Log::info($transDetails);
        \Log::info('Deleted Trans end');

        $memberID    = $transDetails[0]['member_id'];
        $amount      = $transDetails[0]['amount'];
        $mainTransID = $transDetails[0]['main_trans_id'];

        if ($trans->delete()) {
            updatePendingAmount($memberID, $amount, 'credited');

            $creditedTransList = Transaction::where('main_trans_id', $mainTransID)->where('member_id', $memberID)->where('trans_type', '1')->get()->toArray();

            if (count($creditedTransList) > 0) {
                foreach ($creditedTransList as $childTransDetails) {
                    $creditedTransAmount = $childTransDetails['amount'];
                    \Log::info('Deleted Credited Trans start');
                    \Log::info($childTransDetails);
                    \Log::info('Deleted Credited Trans end');
                    Transaction::destroy($childTransDetails['id']);

                    updatePendingAmount($memberID, $creditedTransAmount, 'debited');
                }
            }

            return json_encode(array("message" => trans('alerts.backend.transaction.deleted')));
        }

        return json_encode(array("message" => trans('alerts.backend.transaction.notdeleted')));
    }

    public function deleteChildCreditedTransaction(ManageMainTransactionRequest $request) {
        $id = decryptMethod($request->get('id'));
        $trans = Transaction::where('id', $id);
        $transDetails = $trans->get()->toArray();

        \Log::info('Deleted Trans start');
        \Log::info($transDetails);
        $memberID = $transDetails[0]['member_id'];
        $amount = $transDetails[0]['amount'];
        \Log::info('Deleted Trans end');

        if ($trans->delete()) {
            updatePendingAmount($memberID, $amount, 'debited');
            return json_encode(array("message" => trans('alerts.backend.transaction.deleted')));
        }

        return json_encode(array("message" => trans('alerts.backend.transaction.notdeleted')));
    }

    /**
     * @param \App\Http\Requests\Backend\Events\ManageMainTransactionRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function creditPayment(ManageMainTransactionRequest $request)
    {
        $input = $request->except('_token');

        $validatedData = $request->validate([
            'amount'        => ['required','regex: /^\$?[0-9]?((\.[0-9]+)|([0-9]+(\.[0-9]+)?))$/'],
            'note'          => 'required',
            'member_id'     => 'required',
            'main_trans_id' => 'required',
        ]);

        $memberID = decryptMethod($input['member_id']);

        if (!is_numeric($memberID)) {
            //return redirect()->back()->withInput()->withFlashWarning('');
            return json_encode(array("error" => 'Invalid Member ID.'));
        }

        $existingCreditedRecord = Transaction::where('main_trans_id', $input['main_trans_id'])->where('member_id', $memberID)->where('trans_type', '1')->sum('amount');

        $existingDebitedRecord  = Transaction::where('main_trans_id', $input['main_trans_id'])->where('member_id', $memberID)->where('trans_type', '2')->sum('amount');

        if ( $existingDebitedRecord <= 0 ) {
            return json_encode(array("error" => trans('alerts.backend.transaction.notdebitedforthis')));
        }

        if ( $existingDebitedRecord <= $existingCreditedRecord ) {
            return json_encode(array("error" => trans('alerts.backend.transaction.alreadycredited')));
        } else if ($existingDebitedRecord < $input['amount']) {
            return json_encode(array("error" => trans('alerts.backend.transaction.validamount')));
        }

        $maintransaction = $this->maintransaction->creditPayment($input);

        if ($maintransaction == false) {
            return json_encode(array("error" => trans('alerts.backend.family.wrong')));
            // session()->flash('flash_danger', trans('alerts.backend.family.wrong'));
            // return redirect()->back();
        }

        return json_encode(array("message" => trans('alerts.backend.transaction.credited')));
    }

    /**
     * getMemberTransIDPendingAmount $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function getMemberTransIDPendingAmount(ManageMainTransactionRequest $request)
    {
        $input = $request->except('_token');

        $validatedData = $request->validate([
            'member_id'     => 'required',
            'main_trans_id' => 'required',
        ]);

        $memberID = decryptMethod($input['member_id']);

        if (!is_numeric($memberID)) {
            return json_encode(array("error" => 'Invalid Member ID.'));
        }

        $existingCreditedRecord = Transaction::where('main_trans_id', $input['main_trans_id'])->where('member_id', $memberID)->where('trans_type', '1')->sum('amount');

        $existingDebitedRecord  = Transaction::where('main_trans_id', $input['main_trans_id'])->where('member_id', $memberID)->where('trans_type', '2')->sum('amount');

        $existingCreditedRecord = number_format((float)$existingCreditedRecord, 2, '.', '');
        $existingDebitedRecord = number_format((float)$existingDebitedRecord, 2, '.', '');

        if ( $existingDebitedRecord <= 0 ) {
            return json_encode(array("error" => trans('alerts.backend.transaction.notdebitedforthis')));
        }

        $pendingAmount = $existingDebitedRecord - $existingCreditedRecord;

        $pendingAmount = number_format((float)$pendingAmount, 2, '.', '');

        return json_encode(array("pending_amount" => $pendingAmount));
    }
}
