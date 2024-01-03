<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'user_id',
        'company_id',
        'first_name',
        'last_name',
        'address',
        'locality',
        'province',
        'postal_code',
        'phone_number',
        'email',
        'cuit',
        'subscribed_client',
        'end_client',
        'active'
    ];

    
    /**
     * Get the user associated with the client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {

        return $this->belongsTo(User::class);
    }


    /**
     * Get the company associated with the client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company() {

        return $this->belongsTo(Company::class);
    }
}
