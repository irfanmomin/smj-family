<?php

namespace App\Models\Events;

use App\Models\BaseModel;
use App\Models\Events\Traits\Attribute\SubCategoryAttributes;
use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends BaseModel
{
    use SoftDeletes,
    SubCategoryAttributes;

    protected $fillable = [
        'id',
        'category_id',
        'event_group_id',
        'sub_category_name',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('smj.tables.eventssubcategory');
    }
}
