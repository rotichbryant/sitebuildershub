<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TransactionModel extends Model
{
    use HasFactory, HasUuids;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'confirmation_code',
        'payment_method',
        'status',
        'status_code',
        'reference',
        'tracking_id',
    ];

    /**
     * Get the parent transactionable model.
     */
    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }    
}
