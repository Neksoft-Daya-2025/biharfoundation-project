import { Event } from '../types';

export type EventCategory = 'upcoming' | 'past';

export const getEventCategory = (eventDate: string): EventCategory => {
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  
  const eventDateObj = new Date(eventDate);
  eventDateObj.setHours(0, 0, 0, 0);
  
  return eventDateObj >= today ? 'upcoming' : 'past';
};

export const getUpcomingEvents = (events: Event[]): Event[] => {
  return events
    .filter(event => getEventCategory(event.date) === 'upcoming')
    .sort((a, b) => new Date(a.date).getTime() - new Date(b.date).getTime());
};

export const getPastEvents = (events: Event[]): Event[] => {
  return events
    .filter(event => getEventCategory(event.date) === 'past')
    .sort((a, b) => new Date(b.date).getTime() - new Date(a.date).getTime());
};

export const getAllEventsSorted = (events: Event[]): Event[] => {
  const upcoming = getUpcomingEvents(events);
  const past = getPastEvents(events);
  return [...upcoming, ...past];
};
