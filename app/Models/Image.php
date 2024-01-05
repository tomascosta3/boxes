<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'equipment_id',
        'path',
        'created_by',
        'active'
    ];

    /**
     * Relationship: Many-to-One
     *
     * Define a many-to-one relationship where a Image belongs to a specific Equipment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }


    /**
     * Relationship: Many-to-One
     *
     * Define a many-to-one relationship where a Brand belongs to a specific User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
