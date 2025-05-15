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

    protected $with = [
        'user'
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
     * Get the sub-categories for the category.
     */
    public function childSubCategory(): BelongsTo
    {
        return $this->belongsTo(ChildSubCategoryModel::class, 'child_sub_category_id');
    }     
    
    /**
     * Get the user that owns the posting.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }     
    

    /**
     * Scope a query to filter the postings by a price range.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $column
     * @param  int  $start
     * @param  int  $end
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRange($query, $range)
    {
        return $query->whereBetween('price', $range);
    }
    /**
     * Scope a query to filter the postings by name.
     *
     * This scope allows filtering postings where the name contains
     * the specified substring.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeName($query, $name)
    {
        return $query->where('name', 'like', "%$name%");
    }

    /**
     * Scope a query to filter the postings by sub_categories.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $sub_categories
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSubCategories($query, array $sub_categories)
    {
        return $query->whereHas('subCategory', function ($query) use ($sub_categories) {
            $query->whereIn('name', $sub_categories);
        });
    }

    /**
     * Scope a query to filter the postings by cities.
     *
     * This scope filters the postings based on the specified list of cities.
     * It uses the 'town' column in the database to apply the filter.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $cities
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCities($query, array $cities)
    {
        return $query->whereIn('town', $cities);
    }    
}
