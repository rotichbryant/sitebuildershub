<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryModel extends Model
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
    protected $table = 'categories';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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
     * Get the sub-categories for the category.
     */
    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategoryModel::class, 'category_id');
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
        return $this->hasMany(ChildSubCategoryModel::class, 'category_id');
    }    
}
