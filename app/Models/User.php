<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasUuids, HasFactory, Notifiable;

    public $table = 'users';

    /**
     * The accessors to append to the model's array form.
     *
     * @var string[]
     */
    protected $appends = [
        'activeSubscription',
        'name' // The full name of the user, based on first_name and last_name.
    ];

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
        'token',
        'password',
        'remember_token',
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
    

    public function getNameAttribute() {
        return "$this->first_name $this->last_name";
    }

    public function getActiveSubscriptionAttribute() {
        try {
            return $this->subscription()->where('active',true)->firstOrFail()->subscription;
        } catch(ModelNotFoundException $e){
            return null;
        }
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

    
    /**
     * Get the postings that belong to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\PostingModel>
     */
    public function postings(): HasMany
    {
        /**
         * Define the relationship using the PostingModel class.
         * 
         * @return HasMany<\App\Models\PostingModel>
         */
        return $this->hasMany(
            related: PostingModel::class,
            /**
             * The foreign key on the `users` table that references the `id` column
             * on the `postings` table.
             */
            foreignKey: 'user_id',
        );
    } 

    /**
     * Get the postings that belong to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\ProjectModel>
     */
    public function projects(): HasMany
    {
        /**
         * Define the relationship using the PostingModel class.
         * 
         * @return HasMany<\App\Models\ProjectModel>
         */
        return $this->hasMany(
            related: ProjectModel::class,
            /**
             * The foreign key on the `users` table that references the `id` column
             * on the `postings` table.
             */
            foreignKey: 'user_id',
        );
    }     

    /**
     * Get the business profile that belongs to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\BusinessProfileModel>
     */
    public function business_profile(): HasOne
    {
        /**
         * Define the relationship using the BusinessProfileModel class.
         * 
         * @return HasMany<\App\Models\BusinessProfileModel>
         */
        return $this->hasOne(
            related: BusinessProfileModel::class,
            /**
             * The foreign key on the `users` table that references the `id` column
             * on the `business_profiles` table.
             */
            foreignKey: 'user_id',
        );
    }

    public function subscription()
    {
        return $this->hasOne(UserSubscriptionModel::class);
    }   

    // public function subscription(): HasOneThrough
    // {
    //     /**
    //      * Define the relationship using the BusinessProfileModel class.
    //      * 
    //      * @return HasMany<\App\Models\UserSubscriptionModel>
    //      */
    //     return $this->hasOneThrough(
    //         related: SubscriptionModel::class,
    //         through: UserSubscriptionModel::class,
    //         firstKey: 'user_id',
    //         secondKey: 'id',
    //         localKey: 'id',
    //         secondLocalKey: 'subscription_id',
    //     );
    // }
}
