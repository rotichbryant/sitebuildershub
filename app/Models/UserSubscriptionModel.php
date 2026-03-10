<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

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
     * The subscription that this user is subscribed to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription()
    {
        return $this->belongsTo(SubscriptionModel::class, 'subscription_id');
    }

    /**
     * Get the transaction that the promotion belongs to.
     *
     * This relationship is defined by the `targatable_id` foreign key on the `promotions` table,
     * which references the `id` column on the `transactions` table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\TransactionModel>
     */
    public function transaction(): MorphOne
    {
        // The morphFrom relationship is used to define the relationship between the promotion
        // and the transaction that it belongs to. The morphFrom relationship is a polymorphic
        // relationship that is used to define a relationship between two models that are
        // not directly related. In this case, the promotion model is related to the
        // transaction model using the `targatable_id` foreign key, which references the
        // `id` column on the `transactions` table.
        return $this->morphOne(TransactionModel::class,'targetable');
    }     

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }    
}
