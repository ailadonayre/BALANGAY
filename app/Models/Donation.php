<?php
// app/Models/Donation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'admin_id',
        'title',
        'description',
        'target_amount',
        'current_amount',
        'tribe',
        'image',
        'status',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function getProgressPercentageAttribute()
    {
        if (!$this->target_amount || $this->target_amount == 0) {
            return 0;
        }
        return min(100, ($this->current_amount / $this->target_amount) * 100);
    }
}