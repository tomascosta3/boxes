<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';

    protected $fillable = [
        'type_id',
        'brand',
        'active'
    ];


    /**
     * Relationship: One-to-Many
     *
     * Define a one-to-many relationship where a Brand has multiple associated models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function models()
    {
        return $this->hasMany(EquipmentModel::class);
    }


    /**
     * Get all active models associated with this brand.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function active_models()
    {
        return $this->models()->where('active', true)->get();
    }


    /**
     * Relationship: Many-to-One
     *
     * Define a many-to-one relationship where a Brand belongs to a specific Type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
