<?php

namespace App\Repositories\Backend\Family;

use App\Exceptions\GeneralException;
use App\Models\Family\Family;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use DB;
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
    public function getForDataTable()
    {
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
                config('smj.tables.family').'.surname',
                config('smj.tables.family').'.area',
                config('smj.tables.family').'.city',
                config('smj.tables.family').'.created_at',
            ])->where(config('smj.tables.family').'.is_main', 1)
            ->whereNull(config('smj.tables.family').'.family_id');

        if (!access()->allow('view-all-members-list')) {
            $query->where(config('smj.tables.family').'.created_by', access()->user()->id);
        }

        return $query;
    }

    /**
     * @return mixed
     */
    public function getForAllMembersListDataTable()
    {
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
                config('smj.tables.family').'.surname',
                config('smj.tables.family').'.dob',
                config('smj.tables.family').'.is_main',
                config('smj.tables.family').'.area',
                config('smj.tables.family').'.city',
                config('smj.tables.family').'.created_at',
            ]);

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

        $family->dob = $input['dob'];
        $family->area = $input['area'];
        $family->city = $input['city'];
        $family->mobile = $input['mobile'];
        $family->gender = $input['gender'];
        $family->surname = $input['surname'];
        $family->lastname = $input['lastname'];
        $family->firstname = $input['firstname'];
        $family->relation = isset($input['relation']) ? $input['relation'] : 'Self';
        $family->is_main = isset($input['is_main']) ? $input['is_main'] : '1';
        $family->family_id = isset($input['family_id']) ? $input['family_id'] : NULL;
        $family->created_by = access()->user()->id;
        $family->created_at = Carbon::now();
        $family->updated_at = NULL;

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
}
