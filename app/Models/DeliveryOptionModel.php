<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryOptionModel extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasUuids, HasFactory;

    public $table = 'delivery_options';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'business_profile_id',
        'charged',
        'cost_from',
        'cost_to',
        'delivery_to',
        'delivery_from',
        'location', 
        'name',
    ];

    /**
     * Get the business profile that owns the delivery option.
     */
    public function profile(): BelongsTo
    {
        /**
         * Get the associated business profile.
         * 
         * @return BelongsTo<BusinessProfileModel>
         */
        return $this->belongsTo(BusinessProfileModel::class, 'business_profile_id');
    }

}
