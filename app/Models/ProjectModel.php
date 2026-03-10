<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectModel extends Model
{
use HasFactory, HasUuids;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projects';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'content',
        'end_date',
        'files',
        'title',
        'start_date',
        'user_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:M d, Y',
    ];       
    
    /**
     * Accessor to convert the stored images from JSON to a collection.
     * 
     * The images are stored in the database as a JSON string. This accessor
     * will convert the JSON string to a collection of image paths.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFilesAttribute(): \Illuminate\Support\Collection
    {
        return collect(json_decode($this->attributes['files']))
            ->map(function ($file) {
                // Convert the image path to an absolute URL
                return asset('storage/images/' . $file);
            });
    }

    /**
     * Get the user that owns the posting.
     *
     * This relationship is defined by the `user_id` foreign key on the `postings` table,
     * which references the `id` column on the `users` table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User>
     */
    /**
     * @inheritDoc
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
