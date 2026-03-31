export interface EventTicketType {
  id: number;
  name: string;
  price: number;
  seatsLeft: number;
}

export interface Event {
  id: string;
  numericId: number;
  slug: string;
  title: string;
  date: string;
  time: string;
  location: string;
  description: string;
  longDescription: string;
  image: string;
  price: number;
  gallery?: string[];
  hasTicketTypes?: boolean;
  ticketTypes?: EventTicketType[];
  /** Offline / historical entry not from Laravel; not bookable via API */
  isLegacy?: boolean;
}

export interface Blog {
  id: string;
  title: string;
  excerpt: string;
  content: string;
  author: string;
  date: string;
  image: string;
  category: string;
  gallery?: string[];
}

export interface CartItem {
  eventId: string;
  numericEventId: number;
  title: string;
  price: number;
  quantity: number;
  image: string;
}

export interface MembershipPlan {
  id: string;
  name: string;
  price: number;
  period: 'monthly' | 'yearly';
  features: string[];
  recommended?: boolean;
}

export interface TeamMember {
  id: string;
  name: string;
  role: string;
  image: string;
  bio: string;
}
