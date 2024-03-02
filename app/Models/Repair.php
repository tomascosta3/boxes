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
        'technician_id',
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

    /**
     * Relationship: One-to-One.
     * 
     * Define a one-to-one relationship where a Repair has one Binnacle.
     * Only includes the first Binnacle that is active (where the 'active' column value is true).
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function binnacle()
    {
        return $this->hasOne(Binnacle::class)->where('active', true)->orderBy('created_at', 'asc');
    }

    /**
     * Relationship: Many-to-One.
     * 
     * Define a many-to-one relationship where a Repair belongs to a specific Order.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    /**
     * Relationship: Many-to-One.
     * 
     * Define a many-to-one relationship where a Repair belongs to a specific Technician.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function technician()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Determine if the repair has an assigned technician.
     *
     * @return bool True if a technician is assigned, false otherwise.
     */
    public function has_technician()
    {
        // Check if the technician_id is not null.
        // If it's not null, it means a technician is assigned to this repair.
        return $this->technician_id !== null;
    }


    /**
     * Get the Spanish translation of the repair status.
     *
     * @return string|null The translated status or null if no translation is available.
     */
    public function get_spanish_status()
    {
        switch ($this->status) {
            case 'without checking':
                return 'Sin revisar';
            case 'in progress':
                return 'En progreso';
            case 'completed':
                return 'Completado';
            case 'delivered':
                return 'Entregado';
            case 'waiting':
                return 'En espera';
            default:
                // If no translation is available, return '-'.
                return '-';
        }
    }
}
