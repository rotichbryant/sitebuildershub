<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscriptionModel extends Model
{
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
        'subscription_id',
        'user_id'
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }    
}
