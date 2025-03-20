<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasUuids, HasFactory;

    public $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'icon',
        'logo',
        'address',
        'name',
        'email',
        'phone_number',
    ];

    protected function icon(): Attribute {
        return Attribute::make(
            get: fn ($value) => asset("storage/images/$value"),
        );
    }

    /**
     * The attribute accessor for the company's logo.
     *
     * This accessor retrieves the company's logo from the file system and
     * returns its public URL.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function logo(): Attribute {
        return Attribute::make(
            get: fn ($value) => asset("storage/images/$value"),
        );
    }


    /**
     * The users that belong to the company.
     *
     * This defines a one-to-many relationship between the CompanyModel and UserModel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\User>
     */
    public function users(): HasMany
    {
        return $this->hasMany(
            related: User::class,
        );
    }

    /**
     * Get the roles associated with the company.
     *
     * This defines a one-to-many relationship between the CompanyModel and RoleModel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Role>
     */
    public function roles(): HasMany
    {
        // Define the relationship using the RoleModel class
        return $this->hasMany(
            related: Role::class,
        );
    }
}
