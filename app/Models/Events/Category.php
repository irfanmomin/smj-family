<?php

namespace App\Models\Events;

use App\Models\BaseModel;
use App\Models\Family\Traits\Attribute\FamilyAttribute;
use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends BaseModel
{
    use FamilyAttribute;

    protected $fillable = [
        'id',
        'category_name',
        'created_at',
    ];

    protected $dates = [
        'created_at',
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
        $this->table = config('smj.tables.eventscategory');
    }
}
