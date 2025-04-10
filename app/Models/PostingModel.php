<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostingModel extends Model
{
    use HasFactory, HasUuids;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'postings';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'county',
        'sub_category_id',
        'description',
        'images',
        'location',
        'negotiate',
        'phone_number',
        'price',
        'quantity',
        'title',
        'town',
        'user_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'images'     => 'array',
        'created_at' => 'datetime:M d, Y',
        // 'updated_at' => 'datetime:M d, Y \a\t h:i A',
    ];    
    
    /**
     * Accessor to convert the stored images from JSON to a collection.
     * 
     * The images are stored in the database as a JSON string. This accessor
     * will convert the JSON string to a collection of image paths.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getImagesAttribute(): \Illuminate\Support\Collection
    {
        return collect(json_decode($this->attributes['images']))
            ->map(function ($image) {
                // Convert the image path to an absolute URL
                return asset('storage/images/' . $image);
            });
    }

    /**
     * Get the sub-categories for the category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }

    /**
     * Get the sub-categories for the category.
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategoryModel::class, 'sub_category_id');
    } 
    
    /**
     * Get the user that owns the posting.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }     
    
}
