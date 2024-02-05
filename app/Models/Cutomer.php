<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;





class Cutomer extends Model implements Authenticatable
{
    use Notifiable;

    use HasFactory;

    use AuthenticableTrait;
    protected $guarded = ['id'];

    protected $gurad = 'cutomer';

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function routeNotificationFor($notification)
    {
        return $this->email; // Replace 'email' with the actual field name for the user's email
    }
}
