<?php

namespace App\Repositories\Backend\Events;

use App\Exceptions\GeneralException;
use App\Models\Events\SubCategory;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class SubCategoryRepository.
 */
class SubCategoryRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = SubCategory::class;

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
            ->leftjoin(config('access.users_table'), config('access.users_table').'.id', '=', config("smj.tables.eventssubcategory").'.created_by')
            ->leftjoin(config('smj.tables.eventscategory'), config('smj.tables.eventscategory').'.id', '=', config("smj.tables.eventssubcategory").'.category_id')
            ->leftjoin(config('smj.tables.eventsgroup'), config('smj.tables.eventsgroup').'.id', '=', config("smj.tables.eventssubcategory").'.event_group_id')
            ->select([
                DB::raw('CONCAT(users.first_name, " ", users.last_name) AS creatorName'),
                config('smj.tables.eventscategory').'.category_name',
                config('smj.tables.eventssubcategory').'.id',
                config('smj.tables.eventssubcategory').'.sub_category_name',
                config('smj.tables.eventsgroup').'.event_group_name',
                config('smj.tables.eventssubcategory').'.created_at',
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
     * @param array $input
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function create(array $input)
    {
        $subcategory = self::MODEL;
        $subcategory = new $subcategory();

        $subcategory->category_id       = $input['category_id'];
        $subcategory->event_group_id    = $input['event_group_id'];
        $subcategory->sub_category_name = $input['sub_category_name'];
        $subcategory->created_by        = access()->user()->id;
        $subcategory->created_at        = Carbon::now();

        if ($subcategory->save()) {
            return $subcategory;
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
     * @param \App\Models\Events\Subcategory $subcategory
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(Subcategory $subcategory)
    {
        DB::transaction(function () use ($subcategory) {
            if ($subcategory->delete()) {
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
}
