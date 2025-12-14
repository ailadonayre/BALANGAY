<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeaturedArtist extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'seller_id',
        'name',
        'tribe',
        'craft',
        'image',
        'description',
        'display_order',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'display_order' => 'integer',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true)->orderBy('display_order');
    }
}