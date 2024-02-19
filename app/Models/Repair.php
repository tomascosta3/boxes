<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $table = 'repairs';

    protected $fillable = [
        'order_id',
        'status',
        'conclusion',
        'active',
    ];

    /**
     * Relationship: One-to-Many.
     * 
     * Define a one-to-many relationship where a Repair has multiple Binnacles.
     * Only includes Binnacles that are active (where the 'active' column value is true).
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function binnacles()
    {
        return $this->hasMany(Binnacle::class)->where('active', true);
    }
}
