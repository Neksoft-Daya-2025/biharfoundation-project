import React, { useEffect, useState } from 'react';
import { useParams, Link, useNavigate } from 'react-router-dom';
import { motion } from 'motion/react';
import { getEventCategory } from '../utils/eventUtils';
import { Calendar, MapPin, Clock, ArrowLeft, Plus, Minus, ShoppingCart, Share2, CheckCircle, Camera } from 'lucide-react';
import { useCart } from '../context/CartContext';
import Lightbox from '../components/Lightbox';
import { useLightbox } from '../hooks/useLightbox';
import BookingAttendeeFields from '../components/BookingAttendeeFields';
import { fetchEventBySlug, bookEvent, ApiError } from '../lib/api';
import { mapApiEventToEvent } from '../lib/mapEvent';
import { legacyEvents } from '../data/legacyEvents';
import {
  buildBookingAttendees,
  emptyAttendeeFields,
  type AttendeeField,
} from '../utils/bookingAttendees';
import type { Event } from '../types';

const formatEventContent = (content: string) => {
  const paragraphs = content.split('\n\n');

  return paragraphs.map((paragraph, index) => {
    if (paragraph.startsWith('**') && paragraph.includes('**')) {
      const headingMatch = paragraph.match(/^\*\*(.+?)\*\*/);
      if (headingMatch) {
        const heading = headingMatch[1];
        const restContent = paragraph.replace(/^\*\*.+?\*\*\s*/, '');
        return (
          <div key={index} className="mb-8">
            <h3 className="text-xl md:text-2xl font-serif font-bold text-ink mb-3 flex items-center gap-3">
              <span className="w-8 h-1 bg-saffron rounded-full"></span>
              {heading}
            </h3>
            {restContent && (
              <p className="text-ink/70 leading-relaxed text-base md:text-lg">{restContent}</p>
            )}
          </div>
        );
      }
    }

    if (paragraph.trim()) {
      return (
        <p key={index} className="text-ink/70 leading-relaxed text-base md:text-lg mb-6">
          {paragraph}
        </p>
      );
    }
    return null;
  });
};

const EventDetail = () => {
  const { slug } = useParams();
  const navigate = useNavigate();
  const { addToCart } = useCart();
  const [event, setEvent] = useState<Event | null>(null);
  const [loading, setLoading] = useState(true);
  const [loadError, setLoadError] = useState<string | null>(null);
  const [quantity, setQuantity] = useState(1);
  const [bookingName, setBookingName] = useState('');
  const [bookingAge, setBookingAge] = useState('');
  const [bookingEmail, setBookingEmail] = useState('');
  const [bookingPhone, setBookingPhone] = useState('');
  const [bookingNotes, setBookingNotes] = useState('');
  const [additionalAttendees, setAdditionalAttendees] = useState<AttendeeField[]>(
    [],
  );
  const [bookingSubmitting, setBookingSubmitting] = useState(false);
  const [bookingError, setBookingError] = useState<string | null>(null);
  const [bookingSuccessRef, setBookingSuccessRef] = useState<string | null>(null);

  const [ticketQty, setTicketQty] = useState<Record<number, number>>({});

  const selectedTicketCount = Object.values(ticketQty).reduce(
    (sum, qty) => sum + (qty ?? 0),
    0,
  );
  const activeBookingQuantity =
    event?.hasTicketTypes && (event.ticketTypes?.length ?? 0) > 0
      ? selectedTicketCount
      : quantity;

  useEffect(() => {
    const needed = Math.max(0, activeBookingQuantity - 1);
    setAdditionalAttendees((prev) => {
      if (prev.length === needed) {
        return prev;
      }
      const next = emptyAttendeeFields(needed);
      for (let index = 0; index < Math.min(prev.length, needed); index++) {
        next[index] = prev[index];
      }
      return next;
    });
  }, [activeBookingQuantity]);

  const handleAdditionalAttendeeChange = (
    index: number,
    field: 'name' | 'age',
    value: string,
  ) => {
    setAdditionalAttendees((prev) =>
      prev.map((attendee, attendeeIndex) =>
        attendeeIndex === index ? { ...attendee, [field]: value } : attendee,
      ),
    );
  };

  useEffect(() => {
    if (!slug) return;
    let cancelled = false;
    setLoading(true);
    setLoadError(null);
    void (async () => {
      try {
        const row = await fetchEventBySlug(slug);
        if (cancelled) return;
        const mapped = mapApiEventToEvent(row);
        setEvent(mapped);
        const init: Record<number, number> = {};
        mapped.ticketTypes?.forEach((t) => {
          init[t.id] = 0;
        });
        setTicketQty(init);
      } catch {
        if (!cancelled) {
          const legacy = legacyEvents.find((e) => e.slug === slug);
          if (legacy) {
            setEvent(legacy);
            setLoadError(null);
            const init: Record<number, number> = {};
            legacy.ticketTypes?.forEach((t) => {
              init[t.id] = 0;
            });
            setTicketQty(init);
          } else {
            setLoadError('Event not found or unavailable.');
            setEvent(null);
          }
        }
      } finally {
        if (!cancelled) setLoading(false);
      }
    })();
    return () => {
      cancelled = true;
    };
  }, [slug]);

  const galleryImages = event?.gallery || [];
  const { isOpen, currentIndex, openLightbox, closeLightbox, goToNext, goToPrev } = useLightbox(galleryImages);

  if (loading) {
    return (
      <div className="pt-40 pb-20 text-center text-slate-500">Loading event…</div>
    );
  }

  if (loadError || !event) {
    return (
      <div className="pt-40 pb-20 text-center">
        <h2 className="text-2xl font-bold mb-4">Event not found</h2>
        <Link to="/events" className="btn-primary inline-flex">
          Back to Events
        </Link>
      </div>
    );
  }

  const eventCategory = getEventCategory(event.date);
  const isPastEvent = eventCategory === 'past';
  const hasTickets = event.hasTicketTypes && (event.ticketTypes?.length ?? 0) > 0;
  const canBookOnline = !isPastEvent && event.numericId > 0;

  const handleAddToCart = () => {
    if (hasTickets || !canBookOnline) return;
    addToCart({
      eventId: event.id,
      numericEventId: event.numericId,
      title: event.title,
      price: event.price,
      quantity,
      image: event.image,
    });
    navigate('/cart');
  };

  const adjustTicket = (id: number, delta: number) => {
    const t = event.ticketTypes?.find((x) => x.id === id);
    if (!t) return;
    setTicketQty((prev) => {
      const cur = prev[id] ?? 0;
      const next = Math.max(0, Math.min(t.seatsLeft, cur + delta));
      return { ...prev, [id]: next };
    });
  };

  const submitTicketBooking = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!event || !hasTickets || !canBookOnline) return;
    setBookingError(null);
    setBookingSuccessRef(null);
    const ticket_types: Record<string, number> = {};
    for (const [idStr, q] of Object.entries(ticketQty)) {
      if (q > 0) ticket_types[idStr] = q;
    }
    const totalSel = Object.values(ticket_types).reduce((a, b) => a + b, 0);
    if (totalSel < 1) {
      setBookingError('Please select at least one ticket.');
      return;
    }
    const attendeePayload = buildBookingAttendees(
      bookingName,
      bookingAge,
      additionalAttendees,
      totalSel,
    );
    if ('error' in attendeePayload) {
      setBookingError(attendeePayload.error);
      return;
    }
    setBookingSubmitting(true);
    try {
      const res = await bookEvent(event.numericId, {
        customer_name: bookingName,
        customer_email: bookingEmail,
        customer_phone: bookingPhone || null,
        notes: bookingNotes || null,
        ticket_types,
        attendees: attendeePayload.attendees,
      });
      if (res.success && res.data?.booking_reference) {
        setBookingSuccessRef(res.data.booking_reference);
        if (res.data.confirmation_url) {
          window.location.href = res.data.confirmation_url;
          return;
        }
      }
      setBookingError(res.message || 'Booking failed.');
    } catch (err) {
      if (err instanceof ApiError) {
        const msg =
          (err.body.message as string) ||
          (err.body.errors ? JSON.stringify(err.body.errors) : err.message);
        setBookingError(msg);
      } else {
        setBookingError('Something went wrong.');
      }
    } finally {
      setBookingSubmitting(false);
    }
  };

  const submitSimpleBooking = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!event || hasTickets || isPastEvent || !canBookOnline) return;
    setBookingError(null);
    setBookingSuccessRef(null);
    const attendeePayload = buildBookingAttendees(
      bookingName,
      bookingAge,
      additionalAttendees,
      quantity,
    );
    if ('error' in attendeePayload) {
      setBookingError(attendeePayload.error);
      return;
    }
    setBookingSubmitting(true);
    try {
      const res = await bookEvent(event.numericId, {
        customer_name: bookingName,
        customer_email: bookingEmail,
        customer_phone: bookingPhone || null,
        notes: bookingNotes || null,
        quantity,
        attendees: attendeePayload.attendees,
      });
      if (res.success && res.data?.booking_reference) {
        setBookingSuccessRef(res.data.booking_reference);
        if (res.data.confirmation_url) {
          window.location.href = res.data.confirmation_url;
          return;
        }
      }
      setBookingError(res.message || 'Booking failed.');
    } catch (err) {
      if (err instanceof ApiError) {
        const msg =
          (err.body.message as string) ||
          (err.body.errors ? JSON.stringify(err.body.errors) : err.message);
        setBookingError(msg);
      } else {
        setBookingError('Something went wrong.');
      }
    } finally {
      setBookingSubmitting(false);
    }
  };

  return (
    <div className="pt-20 pb-24 bg-slate-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <Link
          to="/events"
          className="inline-flex items-center gap-2 text-slate-500 hover:text-saffron mb-8 transition-colors"
        >
          <ArrowLeft size={20} /> Back to Events
        </Link>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
          <div className="lg:col-span-2 space-y-12">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              className="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100"
            >
              <div className="relative h-[400px] overflow-hidden">
                <img
                  src={event.image}
                  alt={event.title}
                  className={`w-full h-full object-cover ${isPastEvent ? 'grayscale-[30%]' : ''}`}
                  referrerPolicy="no-referrer"
                />
                {isPastEvent && (
                  <div className="absolute top-6 left-6 bg-ink/90 text-white px-5 py-2.5 rounded-full text-sm font-bold uppercase tracking-wider flex items-center gap-2">
                    <CheckCircle size={16} />
                    Event Completed
                  </div>
                )}
              </div>
              <div className="p-8 md:p-12">
                <div className="flex flex-wrap gap-4 mb-6">
                  <div className="flex items-center gap-2 text-sm font-medium text-slate-500 bg-slate-50 px-4 py-2 rounded-full">
                    <Calendar size={16} className="text-saffron" />
                    {new Date(event.date).toLocaleDateString('en-NL', {
                      weekday: 'long',
                      day: 'numeric',
                      month: 'long',
                      year: 'numeric',
                    })}
                  </div>
                  <div className="flex items-center gap-2 text-sm font-medium text-slate-500 bg-slate-50 px-4 py-2 rounded-full">
                    <Clock size={16} className="text-saffron" />
                    {event.time}
                  </div>
                </div>
                <h1 className="text-4xl md:text-5xl font-serif font-bold text-slate-900 mb-8">
                  {event.title}
                </h1>

                <div className="bg-gradient-to-r from-saffron/5 to-transparent border-l-4 border-saffron pl-6 py-4 mb-8 rounded-r-lg">
                  <p className="text-lg md:text-xl text-ink/80 leading-relaxed font-medium">
                    {event.description}
                  </p>
                </div>

                <div className="space-y-2">{formatEventContent(event.longDescription)}</div>
              </div>
            </motion.div>

            {event.gallery && event.gallery.length > 0 && (
              <section>
                <div className="flex items-center gap-3 mb-6">
                  <Camera size={24} className="text-saffron" />
                  <h2 className="text-2xl font-serif font-bold text-slate-900">
                    {isPastEvent ? 'Event Highlights' : 'Event Gallery'}
                  </h2>
                  <span className="text-sm text-slate-400 ml-auto">Click to enlarge</span>
                </div>
                <div className="columns-2 md:columns-3 gap-4 space-y-4">
                  {event.gallery.map((img, idx) => (
                    <div
                      key={idx}
                      className="break-inside-avoid rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow cursor-pointer group"
                      onClick={() => openLightbox(idx)}
                    >
                      <img
                        src={img}
                        alt={`Gallery ${idx}`}
                        className="w-full h-auto object-contain group-hover:scale-105 transition-transform duration-500"
                        referrerPolicy="no-referrer"
                      />
                    </div>
                  ))}
                </div>
              </section>
            )}

            <Lightbox
              images={galleryImages}
              currentIndex={currentIndex}
              isOpen={isOpen}
              onClose={closeLightbox}
              onNext={goToNext}
              onPrev={goToPrev}
            />
          </div>

          <div className="lg:col-span-1">
            <div className="sticky top-32 space-y-8">
              <motion.div
                initial={{ opacity: 0, x: 20 }}
                animate={{ opacity: 1, x: 0 }}
                className="bg-white rounded-3xl p-8 shadow-xl border border-slate-100"
              >
                {isPastEvent ? (
                  <>
                    <div className="flex items-center gap-3 mb-6">
                      <div className="w-12 h-12 bg-ink/10 rounded-full flex items-center justify-center">
                        <CheckCircle size={24} className="text-ink" />
                      </div>
                      <div>
                        <p className="font-bold text-slate-900">Event Completed</p>
                        <p className="text-sm text-slate-500">This event has ended</p>
                      </div>
                    </div>

                    <div className="space-y-6 mb-8">
                      <div className="flex items-start gap-4">
                        <Calendar size={20} className="text-saffron shrink-0 mt-1" />
                        <div>
                          <p className="font-bold text-slate-900">Date Held</p>
                          <p className="text-sm text-slate-500">
                            {new Date(event.date).toLocaleDateString('en-NL', {
                              weekday: 'long',
                              day: 'numeric',
                              month: 'long',
                              year: 'numeric',
                            })}
                          </p>
                        </div>
                      </div>
                      <div className="flex items-start gap-4">
                        <MapPin size={20} className="text-saffron shrink-0 mt-1" />
                        <div>
                          <p className="font-bold text-slate-900">Location</p>
                          <p className="text-sm text-slate-500">{event.location}</p>
                        </div>
                      </div>
                    </div>

                    <div className="bg-slate-50 rounded-2xl p-6 text-center">
                      <p className="text-slate-600 mb-4">
                        Thank you to everyone who attended this event!
                      </p>
                      <Link
                        to="/events"
                        className="inline-flex items-center justify-center gap-2 bg-ink text-white font-bold uppercase tracking-widest text-sm px-8 py-4 rounded-full hover:bg-ink/80 transition-all w-full"
                      >
                        View Upcoming Events
                      </Link>
                    </div>
                  </>
                ) : hasTickets && canBookOnline ? (
                  <form onSubmit={submitTicketBooking} className="space-y-6">
                    <h3 className="font-bold text-slate-900">Book tickets</h3>
                    {event.ticketTypes?.map((t) => (
                      <div key={t.id} className="flex items-center justify-between gap-4 border-b border-slate-100 pb-4">
                        <div>
                          <p className="font-medium text-slate-900">{t.name}</p>
                          <p className="text-sm text-slate-500">
                            €{t.price.toFixed(2)} · {t.seatsLeft} left
                          </p>
                        </div>
                        <div className="flex items-center gap-3">
                          <button
                            type="button"
                            onClick={() => adjustTicket(t.id, -1)}
                            className="w-9 h-9 rounded-lg border border-slate-200 flex items-center justify-center"
                          >
                            <Minus size={16} />
                          </button>
                          <span className="w-6 text-center font-bold">{ticketQty[t.id] ?? 0}</span>
                          <button
                            type="button"
                            onClick={() => adjustTicket(t.id, 1)}
                            className="w-9 h-9 rounded-lg border border-slate-200 flex items-center justify-center"
                          >
                            <Plus size={16} />
                          </button>
                        </div>
                      </div>
                    ))}
                    <div>
                      <label className="block text-xs font-bold text-slate-600 mb-1">Full name *</label>
                      <input
                        required
                        className="w-full px-3 py-2 border border-slate-200 rounded-lg"
                        value={bookingName}
                        onChange={(e) => setBookingName(e.target.value)}
                      />
                    </div>
                    <BookingAttendeeFields
                      bookerAge={bookingAge}
                      onBookerAgeChange={setBookingAge}
                      additionalAttendees={additionalAttendees}
                      onAdditionalAttendeeChange={handleAdditionalAttendeeChange}
                    />
                    <div>
                      <label className="block text-xs font-bold text-slate-600 mb-1">Email *</label>
                      <input
                        required
                        type="email"
                        className="w-full px-3 py-2 border border-slate-200 rounded-lg"
                        value={bookingEmail}
                        onChange={(e) => setBookingEmail(e.target.value)}
                      />
                    </div>
                    <div>
                      <label className="block text-xs font-bold text-slate-600 mb-1">Phone</label>
                      <input
                        className="w-full px-3 py-2 border border-slate-200 rounded-lg"
                        value={bookingPhone}
                        onChange={(e) => setBookingPhone(e.target.value)}
                      />
                    </div>
                    <div>
                      <label className="block text-xs font-bold text-slate-600 mb-1">Notes</label>
                      <textarea
                        className="w-full px-3 py-2 border border-slate-200 rounded-lg"
                        rows={2}
                        value={bookingNotes}
                        onChange={(e) => setBookingNotes(e.target.value)}
                      />
                    </div>
                    {bookingError && (
                      <p className="text-sm text-red-600">{bookingError}</p>
                    )}
                    {bookingSuccessRef && (
                      <p className="text-sm text-green-700">Reference: {bookingSuccessRef}</p>
                    )}
                    <button
                      type="submit"
                      disabled={bookingSubmitting}
                      className="btn-primary w-full py-4 text-lg disabled:opacity-50"
                    >
                      {bookingSubmitting ? 'Booking…' : 'Complete booking'}
                    </button>
                  </form>
                ) : hasTickets && !canBookOnline ? (
                  <div className="text-sm text-slate-600">
                    <p className="mb-4">Online ticket booking is not available for this listing.</p>
                    <Link to="/contact" className="text-saffron font-bold">
                      Contact us
                    </Link>
                  </div>
                ) : !canBookOnline ? (
                  <>
                    <div className="flex justify-between items-center mb-8">
                      <span className="text-slate-500 font-medium">Ticket Price</span>
                      <span className="text-3xl font-bold text-slate-900">
                        {event.price === 0 ? 'Free' : `€${event.price}`}
                      </span>
                    </div>
                    <div className="space-y-6 mb-8">
                      <div className="flex items-start gap-4">
                        <MapPin size={20} className="text-saffron shrink-0 mt-1" />
                        <div>
                          <p className="font-bold text-slate-900">Location</p>
                          <p className="text-sm text-slate-500">{event.location}</p>
                        </div>
                      </div>
                    </div>
                    <p className="text-sm text-slate-600 mb-4">
                      Details are shown for this upcoming program. Online registration will be available once the event is published for bookings in our system.
                    </p>
                    <Link
                      to="/contact"
                      className="inline-flex items-center justify-center w-full py-3 rounded-full bg-ink text-white font-bold uppercase text-xs tracking-widest hover:bg-ink/90"
                    >
                      Contact us to register
                    </Link>
                  </>
                ) : (
                  <>
                    <div className="flex justify-between items-center mb-8">
                      <span className="text-slate-500 font-medium">Ticket Price</span>
                      <span className="text-3xl font-bold text-slate-900">
                        {event.price === 0 ? 'Free' : `€${event.price}`}
                      </span>
                    </div>

                    <div className="space-y-6 mb-8">
                      <div className="flex items-start gap-4">
                        <MapPin size={20} className="text-saffron shrink-0 mt-1" />
                        <div>
                          <p className="font-bold text-slate-900">Location</p>
                          <p className="text-sm text-slate-500">{event.location}</p>
                        </div>
                      </div>
                    </div>

                    {event.price > 0 && (
                      <div className="space-y-4 mb-8">
                        <label className="block text-sm font-bold text-slate-700">Select Quantity</label>
                        <div className="flex items-center justify-between bg-slate-50 p-2 rounded-2xl border border-slate-100">
                          <button
                            type="button"
                            onClick={() => setQuantity(Math.max(1, quantity - 1))}
                            className="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm hover:text-saffron transition-colors"
                          >
                            <Minus size={18} />
                          </button>
                          <span className="text-xl font-bold">{quantity}</span>
                          <button
                            type="button"
                            onClick={() => setQuantity(quantity + 1)}
                            className="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm hover:text-saffron transition-colors"
                          >
                            <Plus size={18} />
                          </button>
                        </div>
                      </div>
                    )}

                    <div className="space-y-3 mb-4">
                      <button type="button" onClick={handleAddToCart} className="btn-primary w-full py-4 text-lg">
                        {event.price === 0 ? (
                          <>Register (add to bag)</>
                        ) : (
                          <>
                            <ShoppingCart size={20} /> Add to Cart
                          </>
                        )}
                      </button>
                      <p className="text-xs text-center text-slate-400">or book now with your details</p>
                    </div>

                    <form onSubmit={submitSimpleBooking} className="space-y-4 border-t border-slate-100 pt-6">
                      <div>
                        <label className="block text-xs font-bold text-slate-600 mb-1">Full name *</label>
                        <input
                          required
                          className="w-full px-3 py-2 border border-slate-200 rounded-lg"
                          value={bookingName}
                          onChange={(e) => setBookingName(e.target.value)}
                        />
                      </div>
                      <BookingAttendeeFields
                        bookerAge={bookingAge}
                        onBookerAgeChange={setBookingAge}
                        additionalAttendees={additionalAttendees}
                        onAdditionalAttendeeChange={handleAdditionalAttendeeChange}
                      />
                      <div>
                        <label className="block text-xs font-bold text-slate-600 mb-1">Email *</label>
                        <input
                          required
                          type="email"
                          className="w-full px-3 py-2 border border-slate-200 rounded-lg"
                          value={bookingEmail}
                          onChange={(e) => setBookingEmail(e.target.value)}
                        />
                      </div>
                      <div>
                        <label className="block text-xs font-bold text-slate-600 mb-1">Phone</label>
                        <input
                          className="w-full px-3 py-2 border border-slate-200 rounded-lg"
                          value={bookingPhone}
                          onChange={(e) => setBookingPhone(e.target.value)}
                        />
                      </div>
                      <div>
                        <label className="block text-xs font-bold text-slate-600 mb-1">Notes</label>
                        <textarea
                          className="w-full px-3 py-2 border border-slate-200 rounded-lg"
                          rows={2}
                          value={bookingNotes}
                          onChange={(e) => setBookingNotes(e.target.value)}
                        />
                      </div>
                      {bookingError && (
                        <p className="text-sm text-red-600">{bookingError}</p>
                      )}
                      <button
                        type="submit"
                        disabled={bookingSubmitting}
                        className="w-full py-3 rounded-full bg-ink text-white font-bold uppercase text-xs tracking-widest hover:bg-ink/90 disabled:opacity-50"
                      >
                        {bookingSubmitting ? 'Booking…' : 'Book now'}
                      </button>
                    </form>

                    <div className="mt-6 pt-6 border-t border-slate-50 flex items-center justify-center gap-4 text-slate-400">
                      <button type="button" className="hover:text-saffron transition-colors flex items-center gap-2 text-sm">
                        <Share2 size={16} /> Share Event
                      </button>
                    </div>
                  </>
                )}
              </motion.div>

              <div className="bg-orange-50 rounded-3xl p-8 border border-orange-100">
                <h3 className="font-bold text-slate-900 mb-2">Need Help?</h3>
                <p className="text-sm text-slate-600 mb-4">
                  If you have any questions regarding this event, please contact our support team.
                </p>
                <Link to="/contact" className="text-saffron font-bold text-sm">
                  Contact Support
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default EventDetail;
