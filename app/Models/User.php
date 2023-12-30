<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'access_level',
        'verified',
        'verified_at',
        'active'
    ];

    protected $hidden = [
        'password'
    ];
}
