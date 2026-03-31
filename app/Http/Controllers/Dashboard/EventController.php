<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventBooking;
use App\Models\EventTicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('bookings')->orderBy('start_at', 'desc')->get();
        return view('dashboard.events.index', ['events' => $events]);
    }

    public function create()
    {
        return view('dashboard.events.form', ['event' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validateEvent($request);
        $data['slug'] = $this->uniqueSlug($data['title'] ?? '', null);
        $data['status'] = $request->input('status', 'draft');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['max_attendees'] = $request->filled('max_attendees') ? (int) $request->max_attendees : null;
        $data['price_per_ticket'] = (float) ($data['price_per_ticket'] ?? 0);
        $data['image'] = $this->handleEventImage($request, null);
        Event::create($data);
        return redirect()->route('dashboard.events')->with('success', 'Event created.');
    }

    public function show(Event $event)
    {
        $event->load(['bookings.items.ticketType', 'ticketTypes']);
        return view('dashboard.events.show', ['event' => $event]);
    }

    public function edit(Event $event)
    {
        return view('dashboard.events.form', ['event' => $event]);
    }

    public function update(Request $request, Event $event)
    {
        $data = $this->validateEvent($request);
        unset($data['image']); // handle separately so empty URL doesn't clear existing image
        $data['slug'] = $this->uniqueSlug($data['title'] ?? '', $event->id);
        $data['status'] = $request->input('status', 'draft');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['max_attendees'] = $request->filled('max_attendees') ? (int) $request->max_attendees : null;
        $data['price_per_ticket'] = (float) ($data['price_per_ticket'] ?? 0);
        $newImage = $this->handleEventImage($request, $event);
        if ($newImage !== null) {
            $data['image'] = $newImage;
        }
        $event->update($data);
        return redirect()->route('dashboard.events')->with('success', 'Event updated.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('dashboard.events')->with('success', 'Event deleted.');
    }

    /**
     * All bookings (attendees) across events
     */
    public function attendees(Request $request)
    {
        $query = EventBooking::with(['event', 'items.ticketType'])->orderBy('created_at', 'desc');
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $bookings = $query->paginate(20);
        $events = Event::orderBy('start_at', 'desc')->get(['id', 'title']);
        return view('dashboard.events.attendees', ['bookings' => $bookings, 'events' => $events]);
    }

    public function updateBookingStatus(Request $request, EventBooking $booking)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,cancelled']);
        $booking->update(['status' => $request->status]);
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Booking status updated.']);
        }
        return back()->with('success', 'Booking status updated.');
    }

    /**
     * Ticket types & seats management
     */
    public function ticketTypeCreate(Event $event)
    {
        return view('dashboard.events.ticket-type-form', ['event' => $event, 'ticketType' => null]);
    }

    public function ticketTypeStore(Request $request, Event $event)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data['event_id'] = $event->id;
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        EventTicketType::create($data);
        return redirect()->route('dashboard.events.show', $event)->with('success', 'Ticket type added.');
    }

    public function ticketTypeEdit(Event $event, EventTicketType $ticketType)
    {
        if ($ticketType->event_id !== $event->id) {
            abort(404);
        }
        return view('dashboard.events.ticket-type-form', ['event' => $event, 'ticketType' => $ticketType]);
    }

    public function ticketTypeUpdate(Request $request, Event $event, EventTicketType $ticketType)
    {
        if ($ticketType->event_id !== $event->id) {
            abort(404);
        }
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        if ($data['quantity'] < $ticketType->sold) {
            return back()->withInput()->with('error', 'Quantity cannot be less than already sold (' . $ticketType->sold . ').');
        }
        $ticketType->update($data);
        return redirect()->route('dashboard.events.show', $event)->with('success', 'Ticket type updated.');
    }

    public function ticketTypeDestroy(Event $event, EventTicketType $ticketType)
    {
        if ($ticketType->event_id !== $event->id) {
            abort(404);
        }
        if ($ticketType->bookingItems()->exists()) {
            return redirect()->route('dashboard.events.show', $event)->with('error', 'Cannot delete: this ticket type has bookings.');
        }
        $ticketType->delete();
        return redirect()->route('dashboard.events.show', $event)->with('success', 'Ticket type deleted.');
    }

    private function validateEvent(Request $request): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'venue' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'image' => 'nullable|string|max:500',
            'max_attendees' => 'nullable|integer|min:0',
            'price_per_ticket' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|size:3',
        ];
        if ($request->hasFile('image_upload')) {
            $rules['image_upload'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        }
        return $request->validate($rules);
    }

    /**
     * Handle event image: upload file or use URL. Returns path or URL string, or null to keep existing.
     */
    private function handleEventImage(Request $request, ?Event $event): ?string
    {
        if ($request->hasFile('image_upload')) {
            $file = $request->file('image_upload');
            if ($event && $event->image && !str_starts_with($event->image, 'http')) {
                Storage::disk('public')->delete($event->image);
            }
            $path = $file->store('events', 'public');
            return $path;
        }
        if ($request->filled('image')) {
            $img = trim((string) $request->input('image'));
            $img = ltrim($img, '@');
            $img = str_replace('\\', '/', $img);
            if (preg_match('#^public/#i', $img)) {
                $img = (string) preg_replace('#^public/#i', '', $img);
            }
            $img = ltrim($img, '/');

            return $img !== '' ? $img : null;
        }
        return null;
    }

    private function uniqueSlug(string $title, ?int $excludeId): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $n = 0;
        while (Event::where('slug', $slug)->where('id', '!=', $excludeId)->exists()) {
            $slug = $base . '-' . (++$n);
        }
        return $slug;
    }
}
