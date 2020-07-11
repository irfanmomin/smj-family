<?php

namespace App\Models\Family;

use App\Models\BaseModel;
use App\Models\Family\Traits\Attribute\FamilyAttribute;
use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaCity extends BaseModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('smj.tables.areacity');
    }
}