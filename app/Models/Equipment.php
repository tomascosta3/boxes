<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';

    protected $fillable = [
        'client_id',
        'type_id',
        'brand_id',
        'model_id',
        'serial_number',
        'observations',
        'created_by',
        'active'
    ];


    /**
     * Relationship: Many-to-One
     *
     * Define a many-to-one relationship where a Equipment belongs to a specific Client.
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
     * Define a many-to-one relationship where a Equipment belongs to a specific Type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }


    /**
     * Relationship: Many-to-One
     *
     * Define a many-to-one relationship where a Equipment belongs to a specific Brand.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


    /**
     * Relationship: Many-to-One
     *
     * Define a many-to-one relationship where a Equipment belongs to a specific EquipmentModel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function model()
    {
        return $this->belongsTo(EquipmentModel::class);
    }


    /**
     * Relationship: Many-to-One
     *
     * Define a many-to-one relationship where a Equipment belongs to a specific User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Relationship: One-to-Many
     *
     * Defines a one-to-many relationship where an Equipment has many images.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }


    /**
     * Get all active images associated with this equipment.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function active_images()
    {
        return $this->images()->where('active', true)->get();
    }


    /**
     * Relationship: One-to-Many
     *
     * Defines a one-to-many relationship where an Equipment has many orders.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
