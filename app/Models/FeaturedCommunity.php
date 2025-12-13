<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedCommunity extends Model
{
    protected $fillable = [
        'name',
        'region',
        'description',
        'image',
        'active',
        'display_order',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
