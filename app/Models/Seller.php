<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Seller extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'artisan_name',
        'email',
        'phone_number',
        'password',
        'indigenous_tribe',
        'seller_type',
        'shop_name',
        'shop_description',
        'profile_picture',
        'banner_image',
        'address',
        'city',
        'province',
        'postal_code',
        'verification_status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function approvedProducts()
    {
        return $this->hasMany(Product::class)->where('approval_status', 'approved');
    }

    public function pendingProducts()
    {
        return $this->hasMany(Product::class)->where('approval_status', 'pending');
    }
}