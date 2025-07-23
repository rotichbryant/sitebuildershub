<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class PlacementModel extends Model
{
    use HasFactory, HasUuids;
    
    protected $appends = [
        'custom',
        'currency_price'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'advert_placements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'custom',
        'name',
        'price',
        'section',
    ];
    

    protected $withCount = ['postings'];

    public function getCurrencyPriceAttribute(){
        return $this->company->currency." ".$this->price;
    } 
    
    public function getCustomAttribute($value){
        return empty($this->attributes['custom']) ? [ 'height' => 0, 'width' => 0 ] : json_decode($this->attributes['custom']);
    } 
    
    
    /**
     * Get the company that the placement belongs to.
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

    public function postings(): MorphToMany
    {
        return $this->morphedByMany(
            PostingModel::class, 
            'sourceable',
            'transactions',
            'sourceable_id',
            'id',
            'id',
            'id',
        );
    }
}
