import type { Event } from '../types';
import type { ApiEventRow } from './api';

const PLACEHOLDER = '/images/Untitled-1-1.webp';

export function stripHtml(html: string): string {
  if (!html) return '';
  const text = html
    .replace(/<br\s*\/?>/gi, '\n')
    .replace(/<\/p>/gi, '\n\n')
    .replace(/<[^>]+>/g, ' ');
  return text.replace(/\s+/g, ' ').trim();
}

function formatTimeRange(startIso: string | null, endIso: string | null): string {
  if (!startIso) return 'TBA';
  const s = new Date(startIso);
  const start = s.toLocaleTimeString('en-NL', { hour: '2-digit', minute: '2-digit' });
  if (!endIso) return start;
  const e = new Date(endIso);
  const end = e.toLocaleTimeString('en-NL', { hour: '2-digit', minute: '2-digit' });
  return `${start} – ${end}`;
}

function buildLocation(row: ApiEventRow): string {
  const parts = [row.venue?.trim(), row.address?.trim()].filter(Boolean);
  return parts.join(', ') || 'Location TBA';
}

function excerpt(raw: string, max = 280): string {
  const t = stripHtml(raw);
  if (t.length <= max) return t;
  return `${t.slice(0, max).trim()}…`;
}

/** Map Laravel API row to theme Event (uses slug as `id` for routes and cart keys). */
export function mapApiEventToEvent(row: ApiEventRow): Event {
  const date = row.start_at ? row.start_at.slice(0, 10) : new Date().toISOString().slice(0, 10);
  const descRaw = row.description ?? '';
  const price =
    typeof row.price_per_ticket === 'string'
      ? parseFloat(row.price_per_ticket)
      : Number(row.price_per_ticket);

  return {
    id: row.slug,
    numericId: row.id,
    slug: row.slug,
    title: row.title,
    date,
    time: formatTimeRange(row.start_at, row.end_at),
    location: buildLocation(row),
    description: excerpt(descRaw) || row.title,
    longDescription: stripHtml(descRaw) || row.title,
    image: row.image_url || PLACEHOLDER,
    price: Number.isFinite(price) ? price : 0,
    gallery: [],
    hasTicketTypes: row.has_ticket_types,
    ticketTypes: row.ticket_types?.map((t) => ({
      id: t.id,
      name: t.name,
      price: typeof t.price === 'string' ? parseFloat(t.price) : Number(t.price),
      seatsLeft: t.seats_left,
    })),
  };
}
