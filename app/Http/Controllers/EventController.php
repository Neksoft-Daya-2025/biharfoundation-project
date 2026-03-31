<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventBooking;
use App\Models\EventBookingItem;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * List published events (public)
     */
    public function index()
    {
        $events = Event::published()
            ->where('start_at', '>=', now())
            ->orderBy('start_at')
            ->get();
        return view('events.index', ['events' => $events]);
    }

    /**
     * Show single event and booking form (public)
     */
    public function show(string $slug)
    {
        $event = Event::where('slug', $slug)->published()->with('ticketTypes')->firstOrFail();
        return view('events.show', ['event' => $event]);
    }

    /**
     * Create booking (public) – supports single price or ticket types
     */
    public function book(Request $request, Event $event)
    {
        if ($event->status !== 'published') {
            return back()->with('error', 'This event is not available for booking.');
        }
        if ($event->start_at < now()) {
            return back()->with('error', 'This event has already started.');
        }

        $event->load('ticketTypes');

        if ($event->ticketTypes->isNotEmpty()) {
            return $this->bookWithTicketTypes($request, $event);
        }

        // Legacy: single price
        $maxQty = $event->max_attendees
            ? min(10, max(0, $event->max_attendees - $event->bookings()->whereIn('status', ['pending', 'confirmed'])->doesntHave('items')->sum('quantity')))
            : 10;
        if ($maxQty <= 0) {
            return back()->with('error', 'This event is sold out.');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'nullable|string|max:50',
            'quantity' => 'required|integer|min:1|max:' . $maxQty,
            'notes' => 'nullable|string|max:500',
        ]);

        $quantity = (int) $request->quantity;
        $total = $event->price_per_ticket * $quantity;

        $booking = EventBooking::create([
            'event_id' => $event->id,
            'quantity' => $quantity,
            'total_amount' => $total,
            'status' => 'pending',
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'notes' => $request->notes,
        ]);

        Notification::createForAdmin('order', 'New event booking: ' . $event->title, $booking->customer_name . ' booked ' . $quantity . ' ticket(s) – ' . format_money($total), [
            'link' => route('dashboard.events.show', $event),
            'booking_reference' => $booking->booking_reference,
        ]);

        return redirect()->route('events.booking-confirmation', $booking->booking_reference)
            ->with('success', 'Your booking has been received. Reference: ' . $booking->booking_reference);
    }

    /**
     * Create booking with ticket type line items
     */
    private function bookWithTicketTypes(Request $request, Event $event): \Illuminate\Http\RedirectResponse
    {
        $typesById = $event->ticketTypes->keyBy('id');
        $rules = [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
        ];
        foreach ($event->ticketTypes as $type) {
            $max = min(10, $type->seats_left);
            if ($max > 0) {
                $rules['ticket_types.' . $type->id] = 'nullable|integer|min:0|max:' . $max;
            }
        }
        $request->validate($rules);

        $ticketTypes = $request->input('ticket_types', []);
        $items = [];
        $totalAmount = 0;
        $totalQty = 0;
        foreach ($event->ticketTypes as $type) {
            $qty = (int) ($ticketTypes[$type->id] ?? 0);
            if ($qty <= 0) {
                continue;
            }
            if ($qty > $type->seats_left) {
                return back()->with('error', 'Not enough seats left for ' . $type->name . '.')->withInput();
            }
            $items[] = [
                'event_ticket_type_id' => $type->id,
                'quantity' => $qty,
                'unit_price' => $type->price,
                'total_amount' => $type->price * $qty,
            ];
            $totalAmount += $type->price * $qty;
            $totalQty += $qty;
        }

        if (empty($items) || $totalQty < 1) {
            return back()->with('error', 'Please select at least one ticket.')->withInput();
        }

        $booking = EventBooking::create([
            'event_id' => $event->id,
            'quantity' => $totalQty,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'notes' => $request->notes,
        ]);

        foreach ($items as $item) {
            $item['event_booking_id'] = $booking->id;
            EventBookingItem::create($item);
        }

        Notification::createForAdmin('order', 'New event booking: ' . $event->title, $booking->customer_name . ' booked ' . $totalQty . ' ticket(s) – ' . format_money($totalAmount), [
            'link' => route('dashboard.events.show', $event),
            'booking_reference' => $booking->booking_reference,
        ]);

        return redirect()->route('events.booking-confirmation', $booking->booking_reference)
            ->with('success', 'Your booking has been received. Reference: ' . $booking->booking_reference);
    }

    /**
     * Booking confirmation page (public)
     */
    public function bookingConfirmation(string $reference)
    {
        $booking = EventBooking::where('booking_reference', $reference)->with(['event', 'items.ticketType'])->firstOrFail();
        return view('events.booking-confirmation', ['booking' => $booking]);
    }

    /**
     * Published events list (JSON for SPA): upcoming and past, newest first.
     */
    public function apiIndex(): JsonResponse
    {
        $events = Event::published()
            ->orderByDesc('start_at')
            ->get();

        return response()->json([
            'data' => $events->map(fn (Event $e) => $this->eventToArray($e, false)),
        ]);
    }

    /**
     * Single published event by slug (JSON for SPA).
     */
    public function apiShow(string $slug): JsonResponse
    {
        $event = Event::where('slug', $slug)->published()->with('ticketTypes')->firstOrFail();

        return response()->json([
            'data' => $this->eventToArray($event, true),
        ]);
    }

    /**
     * Create booking (JSON for SPA). Mirrors book() / bookWithTicketTypes() validation.
     */
    public function apiBook(Request $request, Event $event): JsonResponse
    {
        if ($event->status !== 'published') {
            return response()->json(['success' => false, 'message' => 'This event is not available for booking.'], 422);
        }
        if ($event->start_at < now()) {
            return response()->json(['success' => false, 'message' => 'This event has already started.'], 422);
        }

        $event->load('ticketTypes');

        if ($event->ticketTypes->isNotEmpty()) {
            return $this->apiBookWithTicketTypes($request, $event);
        }

        $maxQty = $event->max_attendees
            ? min(10, max(0, $event->max_attendees - $event->bookings()->whereIn('status', ['pending', 'confirmed'])->doesntHave('items')->sum('quantity')))
            : 10;
        if ($maxQty <= 0) {
            return response()->json(['success' => false, 'message' => 'This event is sold out.'], 422);
        }

        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'nullable|string|max:50',
            'quantity' => 'required|integer|min:1|max:' . $maxQty,
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $quantity = (int) $request->quantity;
        $total = $event->price_per_ticket * $quantity;

        $booking = EventBooking::create([
            'event_id' => $event->id,
            'quantity' => $quantity,
            'total_amount' => $total,
            'status' => 'pending',
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'notes' => $request->notes,
        ]);

        Notification::createForAdmin('order', 'New event booking: ' . $event->title, $booking->customer_name . ' booked ' . $quantity . ' ticket(s) – ' . format_money($total), [
            'link' => route('dashboard.events.show', $event),
            'booking_reference' => $booking->booking_reference,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your booking has been received.',
            'data' => [
                'booking_reference' => $booking->booking_reference,
                'confirmation_url' => route('events.booking-confirmation', $booking->booking_reference),
            ],
        ], 201);
    }

    private function apiBookWithTicketTypes(Request $request, Event $event): JsonResponse
    {
        $rules = [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
        ];
        foreach ($event->ticketTypes as $type) {
            $max = min(10, $type->seats_left);
            if ($max > 0) {
                $rules['ticket_types.' . $type->id] = 'nullable|integer|min:0|max:' . $max;
            }
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $ticketTypes = $request->input('ticket_types', []);
        $items = [];
        $totalAmount = 0;
        $totalQty = 0;
        foreach ($event->ticketTypes as $type) {
            $qty = (int) ($ticketTypes[$type->id] ?? 0);
            if ($qty <= 0) {
                continue;
            }
            if ($qty > $type->seats_left) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough seats left for ' . $type->name . '.',
                ], 422);
            }
            $items[] = [
                'event_ticket_type_id' => $type->id,
                'quantity' => $qty,
                'unit_price' => $type->price,
                'total_amount' => $type->price * $qty,
            ];
            $totalAmount += $type->price * $qty;
            $totalQty += $qty;
        }

        if (empty($items) || $totalQty < 1) {
            return response()->json(['success' => false, 'message' => 'Please select at least one ticket.'], 422);
        }

        $booking = EventBooking::create([
            'event_id' => $event->id,
            'quantity' => $totalQty,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'notes' => $request->notes,
        ]);

        foreach ($items as $item) {
            $item['event_booking_id'] = $booking->id;
            EventBookingItem::create($item);
        }

        Notification::createForAdmin('order', 'New event booking: ' . $event->title, $booking->customer_name . ' booked ' . $totalQty . ' ticket(s) – ' . format_money($totalAmount), [
            'link' => route('dashboard.events.show', $event),
            'booking_reference' => $booking->booking_reference,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your booking has been received.',
            'data' => [
                'booking_reference' => $booking->booking_reference,
                'confirmation_url' => route('events.booking-confirmation', $booking->booking_reference),
            ],
        ], 201);
    }

    /**
     * @return array<string, mixed>
     */
    private function eventToArray(Event $event, bool $detail): array
    {
        $row = [
            'id' => $event->id,
            'title' => $event->title,
            'slug' => $event->slug,
            'description' => $event->description,
            'venue' => $event->venue,
            'address' => $event->address,
            'start_at' => $event->start_at?->toIso8601String(),
            'end_at' => $event->end_at?->toIso8601String(),
            'image_url' => $event->image_url,
            'max_attendees' => $event->max_attendees,
            'price_per_ticket' => $event->price_per_ticket,
            'currency' => $event->currency,
            'spots_left' => $event->spots_left,
            'has_ticket_types' => $event->has_ticket_types,
        ];

        if ($detail && $event->relationLoaded('ticketTypes')) {
            $row['ticket_types'] = $event->ticketTypes->map(function ($type) {
                return [
                    'id' => $type->id,
                    'name' => $type->name,
                    'description' => $type->description,
                    'price' => $type->price,
                    'quantity' => $type->quantity,
                    'seats_left' => $type->seats_left,
                    'sort_order' => $type->sort_order,
                ];
            })->values()->all();
        }

        return $row;
    }
}
