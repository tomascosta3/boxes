<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Binnacle extends Model
{
    use HasFactory;

    protected $table = 'binnacles';

    protected $fillable = [
        'repair_id',
        'active',
    ];
    
    /**
     * Relationship: One-to-Many.
     * 
     * Define a one-to-many relationship where a Binnacle has multiple Messages.
     * Only includes Messages that are active (where the 'active' column value is true).
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class)->where('active', true);
    }

    /**
     * Relationship: Many-to-One.
     * 
     * Define a many-to-one relationship where a Binnacle belongs to a specific Repair.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function repair()
    {
        return $this->belongsTo(Repair::class);
    }
}
