<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChildSubCategoryModel extends Model
{
    use HasFactory, HasUuids;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'child_sub_categories';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category_id',
        'sub_category_id',
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
     * Get the sub-category that owns the child sub-category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subCategory(): BelongsTo
    {
        // A child sub-category belongs to a sub-category.
        return $this->belongsTo(SubCategoryModel::class, 'sub_category_id');
    }
}
