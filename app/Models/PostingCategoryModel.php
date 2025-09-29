<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostingCategoryModel extends Model
{
    use HasFactory, HasUuids;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posting_categories';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'posting_id',
        'sub_category_id',
    ];

    protected $with = [
        'category','sub_category'
    ];

    /**
     * Get the posting that the posting category belongs to.
     *
     * The posting category is a pivot table that stores the relationship between a posting and a category.
     * This relationship is defined by the `posting_id` foreign key on the `posting_categories` table,
     * which references the `id` column on the `postings` table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\PostingModel>
     */
    public function posting(): BelongsTo
    {
        return $this->belongsTo(PostingModel::class, 'posting_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryModel::class);
    }
    
    public function sub_category(): BelongsTo
    {
        return $this->belongsTo(SubCategoryModel::class);
    }    
}
