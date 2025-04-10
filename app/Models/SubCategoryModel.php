<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCategoryModel extends Model
{
    use HasFactory, HasUuids;
    
    protected $appends = [
        'slug'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sub_categories';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category_id',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:M d, Y',
        // 'updated_at' => 'datetime:M d, Y \a\t h:i A',
    ];    
        
    /**
     * Get the category that owns the sub-category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }

    /**
     * Accessor to convert the name to a slug.
     *
     * @return string
     */
    public function getSlugAttribute(): string
    {
        return preg_replace("/\s+/", "", strtolower($this->name));
    }    

    /**
     * Get the sub-categories for the category.
     */
    public function childSubCategories(): HasMany
    {
        return $this->hasMany(ChildSubCategoryModel::class, 'sub_category_id');
    }        
}
