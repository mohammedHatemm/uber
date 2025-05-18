<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'login_code',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function routeNotificationForTwilio()
    {
        // إذا لم يبدأ الرقم بـ +، أضف رمز البلد
        return strpos($this->phone, '+') === 0 ? $this->phone : '+20' . $this->phone;
    }

    public function driver()
    {
        return $this->hasOne(Driver::class);
    }
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
