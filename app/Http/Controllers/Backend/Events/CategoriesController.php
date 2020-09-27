<?php

namespace App\Http\Controllers\Backend\Events;

use App\Http\Controllers\Controller;
use App\Models\Events\SubCategory;
use App\Repositories\Backend\Events\SubCategoryRepository;
use App\Http\Requests\Backend\Events\ManageCategoryRequest;
use App\Http\Requests\Backend\Events\CreateCategoryRequest;
use App\Http\Requests\Backend\Events\EditCategoryRequest;
use App\Http\Requests\Backend\Events\DeleteCategoryRequest;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Responses\Backend\Events\SubCategories\EditResponse;
use Carbon\Carbon;

/**
 * Class CategoriesController.
 */
class CategoriesController extends Controller
{
    /**
     * @var SubCategoryRepository
     */
    protected $subcategory;

    /**
     * @param \App\Repositories\Backend\Events\SubCategoryRepository $category
     */
    public function __construct(SubCategoryRepository $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    /**
     * @param \App\Http\Requests\Backend\Family\ManageCategoryRequest $request
     *
     * @return \App\Http\Responses\Backend\Family\IndexResponse
     */
    public function index(ManageCategoryRequest $request)
    {
        return new ViewResponse('backend.events.subcategories.index');
    }

    /**
     * @param \App\Http\Requests\Backend\Events\CreateCategoryRequest $request
     *
     * @return mixed
     */
    public function create(CreateCategoryRequest $request)
    {
        // MainEventCategoriesList Array
        $mainEventCategoriesList = getMainEventCategoriesList();
        $getEventGroupsList = getEventGroupsList();

        return view('backend.events.subcategories.create')->with('mainEventCategoriesList', $mainEventCategoriesList)->with('getEventGroupsList', $getEventGroupsList);
    }

    /**
     * @param \App\Http\Requests\Backend\Events\CreateCategoryRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(CreateCategoryRequest $request)
    {
        $input = $request->except('_token');

        $validatedData = $request->validate([
            'sub_category_name' => 'required',
            'category_id'       => 'required',
            'event_group_id'    => 'required',
        ]);

        $subcategory = $this->subcategory->create($input);

        if ($subcategory == false) {
            session()->flash('flash_danger', trans('alerts.backend.family.wrong'));
            return redirect()->back();
        }

        $subcategoryID = $subcategory->id;

        return new RedirectResponse(route('admin.eventsubcategories.index'), ['flash_success' => trans('alerts.backend.events.inserted')]);

    }

    /**
     * @param \App\Models\Events\Subcategory                              $subcategory
     * @param \App\Http\Requests\Backend\Family\EditCategoryRequest $request
     *
     * @return \App\Http\Responses\Backend\Family\EditResponse
     */
    public function edit(Subcategory $subcategory, EditCategoryRequest $request)
    {
        // MainEventCategoriesList Array
        $mainEventCategoriesList = getMainEventCategoriesList();
        $getEventGroupsList      = getEventGroupsList();

        return new EditResponse($subcategory, $mainEventCategoriesList, $getEventGroupsList);
    }

    /**
     * @param \App\Models\Events\Subcategory                              $subcategory
     * @param \App\Http\Requests\Backend\Events\EditCategoryRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(Subcategory $subcategory, EditCategoryRequest $request)
    {
        $input = $request->all();

        $validatedData = $request->validate([
            'sub_category_name' => 'required',
            'category_id'       => 'required',
            'event_group_id'    => 'required',
        ]);

        $this->subcategory->update($subcategory, $request->except(['_token', '_method']));

        return new RedirectResponse(route('admin.eventsubcategories.index'), ['flash_success' => trans('alerts.backend.events.updated')]);
    }

    /**
     * @param \App\Models\Events\Subcategory                              $subcategory
     * @param \App\Http\Requests\Backend\Family\DeleteCategoryRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Subcategory $subcategory, DeleteCategoryRequest $request)
    {
        $this->subcategory->delete($subcategory);

        return new RedirectResponse(route('admin.eventsubcategories.index'), ['flash_success' => trans('alerts.backend.events.deleted')]);
    }
}
