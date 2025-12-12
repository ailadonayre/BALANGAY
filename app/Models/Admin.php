<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'full_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function featuredArtists()
    {
        return $this->hasMany(FeaturedArtist::class);
    }
}