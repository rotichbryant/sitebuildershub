<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasUuids, HasFactory;

    public $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'state',
        'company_id',
    ];

    /**
     * Scope a query to only include client roles.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeClient($query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('state', 0);
    }

    /**
     * Get the users that have this role.
     *
     * This defines a one-to-many relationship between the RoleModel and UserModel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\User>
     */
    public function users(): HasMany
    {
        // Define the relationship using the UserModel class
        return $this->hasMany(User::class);
    }

    /**
     * Get the company that the role belongs to.
     *
     * This relationship is defined by the `company_id` foreign key on the `roles` table,
     * which references the `id` column on the `companies` table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\CompanyModel>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(
            related: Company::class,
            /**
             * The foreign key on the `roles` table that references the `id` column
             * on the `companies` table.
             */
            foreignKey: 'company_id',
            /**
             * The owner key on the `companies` table that references the `id` column
             * on the `roles` table.
             */
            ownerKey: 'id',
        );
    }
  
}
