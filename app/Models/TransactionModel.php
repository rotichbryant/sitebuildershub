<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TransactionModel extends Model
{
    use HasFactory, HasUuids;
    
    protected $appends = [
        'complete',
        'source_type'
    ]; 

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
        'sourceable_id',
        'sourceable_target',
        'targetable_id',
        'targetable_target',
        'tracking_id',
        'user_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount'     => 'decimal:2',
        'created_at' => 'datetime:M d, Y H:i:s',
        'paid_at'    => 'datetime:M d, Y H:i:s',
    ];      

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

    
    public function getCompleteAttribute()
    {
        return $this->attributes['status'] == "200";
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
    
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
