<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'room_id',
        'user_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function canBeEdited(): bool
    {
        return $this->status === 'pending' && $this->start_time > now();
    }

    public function canBeCancelled(): bool
    {
        return $this->status === 'pending' || ($this->status === 'approved' && $this->start_time > now());
    }
}
