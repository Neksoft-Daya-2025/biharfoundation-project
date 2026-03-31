import type { Event } from '../types';

/** API row wins when the same slug exists in both lists. */
export function mergeEventsBySlug(apiEvents: Event[], legacyEvents: Event[]): Event[] {
  const bySlug = new Map<string, Event>();
  for (const e of legacyEvents) {
    bySlug.set(e.slug, e);
  }
  for (const e of apiEvents) {
    bySlug.set(e.slug, e);
  }
  return Array.from(bySlug.values());
}
