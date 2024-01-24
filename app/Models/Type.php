<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $table = 'types';

    protected $fillable = [
        'type',
        'active'
    ];

    
    /**
     * Relationship: One-to-Many
     *
     * Define a one-to-many relationship where a Type has multiple associated brands.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function brands()
    {
        return $this->hasMany(Brand::class);
    }


    /**
     * Get all active brands associated with this type.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function active_brands()
    {
        return $this->brands()->where('active', true)->get();
    }
}
