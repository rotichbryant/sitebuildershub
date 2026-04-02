<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphOneOrMany;

class UserSubscriptionModel extends Model
{
    use HasFactory, HasUuids;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_subscription';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'active',
        'end_date',
        'start_date',
        'subscription_id',
        'user_id'
    ];    

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'end_date'   => 'datetime:M d, Y',
        'start_date' => 'datetime:M d, Y',
    ];    


    /**
     * The subscription that this user is subscribed to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription()
    {
        return $this->belongsTo(SubscriptionModel::class, 'subscription_id');
    }

    /**
     * Get all transactions for the order.
     */
    public function invoices(): MorphMany
    {
        return $this->morphMany(InvoiceModel::class, 'targetable');
    }  

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }    
}
