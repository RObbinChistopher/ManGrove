<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // Add the fillable property
    protected $fillable = [
        'name', 'email', 'phone', 'agent_id', 'password'
    ];

    // Method to generate a unique 6-digit agent_id
    function generateUniqueUserId()
    {
        do {
            $uniqueId = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        } while (\App\Models\User::where('agent_id', $uniqueId)->exists());

        return $uniqueId;
    }
}
