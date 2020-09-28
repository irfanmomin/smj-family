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

        return new RedirectResponse(route('admin.maintransactions.index'), ['flash_success' => trans('alerts.backend.events.inserted')]);

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

        return new RedirectResponse(route('admin.maintransactions.index'), ['flash_success' => trans('alerts.backend.events.deleted')]);
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
            $subCategoryList = getsubCategoryList($categoryID);

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
        /* $query =  Transaction::leftjoin(config('access.users_table'), config('access.users_table').'.id', '=', config("smj.tables.transtable").'.created_by')
            ->leftjoin(config('smj.tables.maintranstable'), config('smj.tables.maintranstable').'.id', '=', config("smj.tables.transtable").'.main_trans_id')
            ->leftjoin(config('smj.tables.eventssubcategory'), config('smj.tables.eventssubcategory').'.id', '=', config("smj.tables.maintranstable").'.sub_category_id')
            ->leftjoin(config('smj.tables.eventsgroup'), config('smj.tables.eventsgroup').'.id', '=', config("smj.tables.eventssubcategory").'.event_group_id')
            ->where(config('smj.tables.transtable').'.main_trans_id', $id)
            ->select([
                DB::raw('CONCAT(users.first_name, " ", users.last_name) AS creatorName'),
                config('smj.tables.transtable').'.id',
                config('smj.tables.eventssubcategory').'.sub_category_name',
                config('smj.tables.eventsgroup').'.event_group_name',
                config('smj.tables.maintranstable').'.amount',
                config('smj.tables.maintranstable').'.created_at',
            ]);

        $allChildTrans = $query->get()->toArray(); */

        return view('backend.events.eventmaintransactions.childtranslist')->with('id', $id);
    }

    public function deleteChildTransaction(ManageMainTransactionRequest $request) {
        $id = decryptMethod($request->get('id'));
        $trans = Transaction::where('id', $id);
        $transDetails = $trans->get()->toArray();

        \Log::info('Deleted Trans start');
        \Log::info($transDetails);
        $memberID = $transDetails[0]['member_id'];
        $amount = $transDetails[0]['amount'];
        \Log::info('Deleted Trans end');

        if ($trans->delete()) {
            updatePendingAmount($memberID, $amount, 'credited');
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
            'amount'    => ['required','regex: /^\$?[0-9]?((\.[0-9]+)|([0-9]+(\.[0-9]+)?))$/'],
            'note'      => 'required',
            'member_id' => 'required',
        ]);

        $memberID = decryptMethod($input['member_id']);

        if (!is_numeric($memberID)) {
            return redirect()->back()->withInput()->withFlashWarning('Invalid Member ID.');
        }

        $maintransaction = $this->maintransaction->creditPayment($input);

        if ($maintransaction == false) {
            session()->flash('flash_danger', trans('alerts.backend.family.wrong'));
            return redirect()->back();
        }

        return json_encode(array("message" => trans('alerts.backend.transaction.credited')));

    }
}
