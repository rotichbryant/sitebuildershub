<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class SubscriptionModel extends Model
{
    use HasFactory, HasUuids;
    
    protected $appends = [
        'currency_price'
    ];

    protected $casts = [
        'active' => 'boolean',
        'default' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'active',
        'company_id',
        'default',
        'description',
        'features',
        'name',
        'price',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table     = 'subscriptions';

    protected $withCount = ['users'];

    public function getCurrencyPriceAttribute(){
        return $this->company->currency." ".$this->price;
    }

    public function getFeaturesAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Get all transactions for the order.
     */
    public function invoices(): MorphMany
    {
        return $this->morphMany(InvoiceModel::class, 'sourcable');
    }  
    
    /**
     * Get the company that the subscription belongs to.
     *
     * This relationship is defined by the `company_id` foreign key on the `subscriptions` table,
     * which references the `id` column on the `companies` table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\CompanyModel>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(
            related: Company::class,
            foreignKey: 'company_id'
        );
    }

    /**
     * Get all transactions for the order.
     *
     * This relationship is defined by the `subscription_id` foreign key on the `user_subscriptions` table,
     * which references the `id` column on the `subscriptions` table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\UserSubscriptionModel>
     */
    public function users(): HasMany
    {
        return $this->hasMany(UserSubscriptionModel::class, 'subscription_id');
    }      
}
