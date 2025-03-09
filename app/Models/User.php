<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasUuids, HasFactory, Notifiable;

    public $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'company_id',
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'password',
        'role_id',
        'token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function name(): Attribute {
        return Attribute::make(
            get: fn () => "$this->first_name $this->last_name",
        );
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * The roles that belong to the User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Role>
     */
    public function role(): BelongsTo
    {
        /**
         * Define the relationship using the RoleModel class.
         * 
         * @return BelongsTo<\App\Models\Role>
         */
        return $this->belongsTo(
            related: Role::class,
            /**
             * The foreign key on the `users` table that references the `id` column
             * on the `roles` table.
             */
            foreignKey: 'role_id',
            /**
             * The owner key on the `roles` table that references the `id` column
             * on the `users` table.
             */
            ownerKey: 'id'
        );
    }

    /**
     * Get the company that the user belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\CompanyModel>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(
            related: Company::class,
            /**
             * The foreign key on the `users` table that references the `id` column
             * on the `companies` table.
             */
            foreignKey: 'company_id',
            /**
             * The owner key on the `companies` table that references the `id` column
             * on the `users` table.
             */
            ownerKey: 'id',
        );
    }
    
}
