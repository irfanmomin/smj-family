<?php

namespace App\Models\Events;

use App\Models\BaseModel;
use App\Models\Events\Traits\Attribute\MainTransactionAttributes;
use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainTransaction extends BaseModel
{
    use SoftDeletes,
    MainTransactionAttributes;

    protected $fillable = [
        'id',
        'category_id',
        'sub_category_id',
        'amount',
        'created_at',
        'created_by',
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
        $this->table = config('smj.tables.maintranstable');
    }
}
