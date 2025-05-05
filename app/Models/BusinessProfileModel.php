<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BusinessProfileModel extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasUuids, HasFactory;


    public $table = 'business_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'about',
        'email',
        'name',
        'phone_number',
        'user_id'
    ];

    // public $with = ['stores'];
    
    /**
     * Get all of the delivery options for the business profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\DeliveryOptionModel>
     */
    public function deliveryOptions(): HasMany
    {
        return $this->hasMany(DeliveryOptionModel::class, 'business_profile_id');
    } 

    /**
     * Get all of the stores for the business profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\BusinessStoreModel>
     */
    public function stores(): HasMany
    {
        return $this->hasMany(BusinessStoreModel::class, 'business_profile_id');
    }

    /**
     * Get the user that owns the business profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }      

}
