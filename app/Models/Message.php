<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'user_id',
        'message',
        'active',
        'private',
    ];

    /**
     * Relationship: Many-to-One.
     * 
     * Define a many-to-one relationship where a Message belongs to a specific Binnacle.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Many-to-One.
     * 
     * Define a many-to-one relationship where a Message belongs to a specific Binnacle.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function binnacle()
    {
        return $this->belongsTo(Binnacle::class);
    }
}
