<?php
// app/Models/Seller.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Seller model properties
 *
 * @property int $id
 * @property string|null $artisan_name
 * @property string $email
 * @property string|null $phone_number
 * @property string|null $indigenous_tribe
 * @property string|null $seller_type
 * @property string|null $shop_name
 * @property string|null $shop_description
 * @property string|null $profile_picture
 * @property string|null $banner_image
 * @property string|null $verification_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * Relationships
 * @property-read HasMany $products
 * @property-read HasMany $approvedProducts
 * @property-read HasMany $pendingProducts
 * @property-read HasMany $orderItems
 * @property-read HasManyThrough $orders
 */
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
        'password' => 'hashed',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function approvedProducts()
    {
        return $this->hasMany(Product::class)->where('approval_status', 'approved');
    }

    public function pendingProducts()
    {
        return $this->hasMany(Product::class)->where('approval_status', 'pending');
    }

    public function orders()
    {
        return $this->hasManyThrough(Order::class, Product::class, 'seller_id', 'id', 'id', 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'seller_id');
    }
}