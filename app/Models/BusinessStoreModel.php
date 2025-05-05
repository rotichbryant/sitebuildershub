<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessStoreModel extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasUuids, HasFactory;

    public $table = 'business_stores';

    /**
     * The attributes that are mass assignable.
    *
    * @var list<string>
    */
    protected $fillable = [
        'address',
        'business_profile_id',
        'open_from',
        'open_to',
        'location',
        'name',
        'tips',
        'working_days',
    ];
    
    /**
     * Get the business profile associated with the business store.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\BusinessProfileModel>
     */
    public function business_profile(): BelongsTo
    {
        // Establish a relationship where the business store belongs to a business profile
        return $this->belongsTo(BusinessProfileModel::class, 'business_profile_id');
    }
}
