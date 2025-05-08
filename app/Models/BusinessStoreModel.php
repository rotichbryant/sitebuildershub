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

    protected $appends = [
        'timeline'
    ];

    public $table = 'business_stores';

    /**
     * The attributes that are mass assignable.
    *
    * @var list<string>
    */
    protected $fillable = [
        'business_profile_id',
        'coords',
        'open_from',
        'open_to',
        'location',
        'name',
        'tips',
        'working_days',
    ];

        /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'coords'       => 'object',
            'open_from'    => 'object',
            'open_to'      => 'object',
            'working_days' => 'array',
        ];
    }
    
    /**
     * Accessor to convert the name to a slug.
     *
     * @return string
     */
    public function getTimelineAttribute(): array
    {
        $timeline = collect($this->working_days)->sortBy('id');
        return array(
            'first' => $timeline->first()['name'],
            'last'  => $timeline->last()['name'],
        );
    }

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
