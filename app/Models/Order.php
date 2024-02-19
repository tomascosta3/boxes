<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'number',
        'client_id',
        'equipment_id',
        'accessories',
        'failure',
        'active',
        'user_id'
    ];


    /**
     * Relationship: Many-to-One
     * 
     * Define a many-to-one relationship where a Order belongs to a specific User.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Relationship: Many-to-One
     *
     * Define a many-to-one relationship where a Order belongs to a specific Client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }


    /**
     * Relationship: Many-to-One
     *
     * Define a many-to-one relationship where a Order belongs to a specific Equipment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }


    /**
     * Relationship: One-to-One
     *
     * Define a one-to-one relationship where an Order has one Repair.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function repair()
    {
        return $this->hasOne(Repair::class);
    }
}
