<?php

namespace App\Models\Events;

use App\Models\BaseModel;
use App\Models\ModelTrait;

class Transaction extends BaseModel
{
    protected $fillable = [
        'id',
        'main_trans_id',
        'member_id',
        'trans_type',
        'amount',
        'receipt_no',
        'note',
        'transaction_date',
        'created_at',
        'created_by',
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
        $this->table = config('smj.tables.transtable');
    }
}
