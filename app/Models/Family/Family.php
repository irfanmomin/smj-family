<?php

namespace App\Models\Family;

use App\Models\BaseModel;
use App\Models\Family\Traits\Attribute\FamilyAttribute;
use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Family extends BaseModel
{
    use SoftDeletes,
        FamilyAttribute;

    protected $fillable = [
        'id',
        'family_id',
        'firstname',
        'lastname',
        'surname',
        'mobile',
        'dob',
        'gender',
        'relation',
        'city',
        'area',
        'is_main',
        'expired_date',
        'created_by',
        'updated_by',
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
        $this->table = config('smj.tables.family');
    }
}
