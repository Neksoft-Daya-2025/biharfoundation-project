import React, { createContext, useCallback, useContext, useEffect, useMemo, useState } from 'react';
import type { Event } from '../types';
import { fetchEventsList } from '../lib/api';
import { mapApiEventToEvent } from '../lib/mapEvent';
import { legacyEvents } from '../data/legacyEvents';
import { mergeEventsBySlug } from '../lib/mergeLegacyEvents';

type EventsContextValue = {
  events: Event[];
  loading: boolean;
  error: string | null;
  refresh: () => Promise<void>;
};

const EventsContext = createContext<EventsContextValue | undefined>(undefined);

export const EventsProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [apiEvents, setApiEvents] = useState<Event[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  const events = useMemo(
    () => mergeEventsBySlug(apiEvents, legacyEvents),
    [apiEvents],
  );

  const refresh = useCallback(async () => {
    setLoading(true);
    setError(null);
    try {
      const rows = await fetchEventsList();
      setApiEvents(rows.map(mapApiEventToEvent));
    } catch (e) {
      setError(e instanceof Error ? e.message : 'Could not load events.');
      setApiEvents([]);
    } finally {
      setLoading(false);
    }
  }, []);

  useEffect(() => {
    void refresh();
  }, [refresh]);

  return (
    <EventsContext.Provider value={{ events, loading, error, refresh }}>
      {children}
    </EventsContext.Provider>
  );
};

export function useEvents(): EventsContextValue {
  const ctx = useContext(EventsContext);
  if (!ctx) {
    throw new Error('useEvents must be used within EventsProvider');
  }
  return ctx;
}
