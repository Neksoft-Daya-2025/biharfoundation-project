<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventTicketType extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'description',
        'price',
        'quantity',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function bookingItems()
    {
        return $this->hasMany(EventBookingItem::class, 'event_ticket_type_id');
    }

    /**
     * Number of seats/tickets sold (pending + confirmed bookings).
     */
    public function getSoldAttribute(): int
    {
        return $this->bookingItems()
            ->whereHas('booking', fn ($q) => $q->whereIn('status', ['pending', 'confirmed']))
            ->sum('quantity');
    }

    /**
     * Seats left for this ticket type.
     */
    public function getSeatsLeftAttribute(): int
    {
        return max(0, $this->quantity - $this->sold);
    }

    /**
     * Whether this type has any seats left.
     */
    public function getHasSeatsLeftAttribute(): bool
    {
        return $this->seats_left > 0;
    }
}
