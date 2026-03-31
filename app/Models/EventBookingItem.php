<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventBookingItem extends Model
{
    protected $fillable = [
        'event_booking_id',
        'event_ticket_type_id',
        'quantity',
        'unit_price',
        'total_amount',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function booking()
    {
        return $this->belongsTo(EventBooking::class, 'event_booking_id');
    }

    public function ticketType()
    {
        return $this->belongsTo(EventTicketType::class, 'event_ticket_type_id');
    }
}
