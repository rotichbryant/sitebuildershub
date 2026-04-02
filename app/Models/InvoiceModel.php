<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class InvoiceModel extends Model
{
  /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasUuids, HasFactory;

    public $table = 'invoices';

    protected $appends = [
        'currency_amount',
        'source_type',
        'pending_transaction'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'amount',
        'due_date',
        'invoice_number',
        'sourceable_id',
        'sourceable_type',
        'status',
        'targetable_id',
        'targetable_type',
        'tracking_id',
        'user_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount'         => 'decimal:2',
        'created_at'     => 'datetime:d M, Y',
        'due_date'       => 'datetime',
        'invoice_number' => 'integer'
    ];    

    protected $with = [
        'sourceable',
        'targetable',
        'transactions',
        'user'
    ];

    public function getCurrencyAmountAttribute()
    {
        return "{$this->user->company->currency} {$this->amount}";
    }

    /**
     * Get the source type attribute.
     * 
     * This attribute is added to the model and is determined by the sourceable_type
     * of the model. If the sourceable_type is 'App\Models\PlacementModel', the
     * source_type is 'placement'. If the sourceable_type is 'App\Models\SubscriptionModel',
     * the source_type is 'subscription'.
     * 
     * @return string
     */
    public function getSourceTypeAttribute()
    {
        if( $this->sourceable_type == 'App\Models\PlacementModel' ){
            return 'placement';
        }

        if( $this->sourceable_type == 'App\Models\SubscriptionModel' ){
            return 'subscription';
        }      
    }

    public function getPendingTransactionAttribute()
    {
        return !empty($this->transactions()->pending()->count()) ? $this->transactions()->pending() : null;
    }    

    /**
     * Get the parent transactionable model.
     */
    public function sourceable(): MorphTo
    {
        return $this->morphTo();
    }  
    

    /**
     * Get the parent transactionable model.
     */
    public function targetable(): MorphTo
    {
        return $this->morphTo();
    }     
    
    /**
     * Get the transactions associated with the invoice.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\User>
     */
    public function transactions(): HasMany
    {
        /**
         * This relationship is defined by the `invoice_id` foreign key on the `users` table,
         * which references the `id` column on the `invoices` table.
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\User>
         */
        return $this->hasMany(TransactionModel::class,'invoice_id','id');
    }    

    /**
     * Get the user that owns the invoice.
     *
     * This relationship is defined by the `user_id` foreign key on the `invoices` table,
     * which references the `id` column on the `users` table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User>
     */
    /**
     * @mixin BelongsTo
     *
     * @param string $related
     * @param string $foreignKey
     * @param string $ownerKey
     * @param string $relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }  
        
}
