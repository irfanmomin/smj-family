<?php

namespace App\Models\Events;

use App\Models\BaseModel;
use App\Models\ModelTrait;

class PendingAmount extends BaseModel
{
    protected $fillable = [
        'id',
        'member_id',
        'pending_amount',
    ];

    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('smj.tables.pendingamount');
    }
}
