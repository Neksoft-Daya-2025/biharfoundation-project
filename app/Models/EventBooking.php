<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventBooking extends Model
{
    protected $fillable = [
        'event_id',
        'booking_reference',
        'quantity',
        'total_amount',
        'status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'total_amount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($booking) {
            if (empty($booking->booking_reference)) {
                $booking->booking_reference = 'EVT-' . strtoupper(Str::random(8));
            }
        });
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function items()
    {
        return $this->hasMany(EventBookingItem::class, 'event_booking_id');
    }

    public function getAttendeesCountAttribute(): int
    {
        if ($this->items->isNotEmpty()) {
            return $this->items->sum('quantity');
        }
        return $this->quantity;
    }

    /** Total from line items when present. */
    public function getTotalFromItemsAttribute(): ?float
    {
        if ($this->items->isEmpty()) {
            return null;
        }
        return (float) $this->items->sum('total_amount');
    }
}
