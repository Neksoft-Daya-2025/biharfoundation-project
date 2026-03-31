<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'venue',
        'address',
        'start_at',
        'end_at',
        'image',
        'max_attendees',
        'price_per_ticket',
        'currency',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'price_per_ticket' => 'decimal:2',
        'max_attendees' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }
        });
    }

    public function bookings()
    {
        return $this->hasMany(EventBooking::class);
    }

    public function ticketTypes()
    {
        return $this->hasMany(EventTicketType::class, 'event_id')->orderBy('sort_order');
    }

    public function getTotalBookedAttribute(): int
    {
        $fromItems = EventBookingItem::whereHas('booking', function ($q) {
            $q->where('event_id', $this->id)->whereIn('status', ['pending', 'confirmed']);
        })->sum('quantity');
        $fromLegacy = $this->bookings()->whereIn('status', ['pending', 'confirmed'])->doesntHave('items')->sum('quantity');
        return (int) ($fromItems + $fromLegacy);
    }

    /** Whether this event uses ticket types (vs single price). */
    public function getHasTicketTypesAttribute(): bool
    {
        return $this->ticketTypes()->exists();
    }

    public function getSpotsLeftAttribute(): ?int
    {
        if ($this->max_attendees === null || $this->max_attendees <= 0) {
            return null; // unlimited
        }
        return max(0, $this->max_attendees - $this->total_booked);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Full URL for the event image (storage upload, file under public/, or absolute URL).
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image === null || $this->image === '') {
            return null;
        }

        $raw = trim((string) $this->image);
        $raw = ltrim($raw, '@');
        $raw = str_replace('\\', '/', $raw);

        if (str_starts_with($raw, 'http://') || str_starts_with($raw, 'https://')) {
            return $raw;
        }

        $underPublic = preg_replace('#^public/#i', '', $raw);
        $underPublic = ltrim($underPublic, '/');

        if ($underPublic !== '') {
            $local = public_path(str_replace('/', DIRECTORY_SEPARATOR, $underPublic));
            if (is_file($local)) {
                return asset($underPublic);
            }
        }

        foreach (array_unique(array_filter([$underPublic, ltrim($raw, '/')])) as $diskPath) {
            if (Storage::disk('public')->exists($diskPath)) {
                return Storage::disk('public')->url($diskPath);
            }
        }

        return Storage::disk('public')->url(ltrim($raw, '/'));
    }
}
