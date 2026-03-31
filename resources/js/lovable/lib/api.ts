const API_BASE = '/api/v1';

export function getCsrfToken(): string {
  return document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content ?? '';
}

export class ApiError extends Error {
  constructor(
    public status: number,
    public body: Record<string, unknown>,
  ) {
    super(
      (body.message as string) ||
        (body.error as string) ||
        `Request failed (${status})`,
    );
    this.name = 'ApiError';
  }
}

export async function apiFetch<T>(
  path: string,
  init: RequestInit = {},
): Promise<T> {
  const headers: HeadersInit = {
    Accept: 'application/json',
    'Content-Type': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
    ...(init.headers as Record<string, string>),
  };

  const method = (init.method ?? 'GET').toUpperCase();
  if (method !== 'GET' && method !== 'HEAD') {
    (headers as Record<string, string>)['X-CSRF-TOKEN'] = getCsrfToken();
  }

  const res = await fetch(`${API_BASE}${path}`, {
    credentials: 'same-origin',
    ...init,
    headers,
  });

  const data = (await res.json().catch(() => ({}))) as Record<string, unknown>;

  if (!res.ok) {
    throw new ApiError(res.status, data);
  }

  return data as T;
}

export type ApiTicketType = {
  id: number;
  name: string;
  description?: string | null;
  price: string | number;
  quantity?: number;
  seats_left: number;
  sort_order?: number;
};

export type ApiEventRow = {
  id: number;
  slug: string;
  title: string;
  description?: string | null;
  venue?: string | null;
  address?: string | null;
  start_at: string | null;
  end_at: string | null;
  image_url: string | null;
  price_per_ticket: string | number;
  currency?: string | null;
  spots_left: number | null;
  has_ticket_types: boolean;
  ticket_types?: ApiTicketType[];
};

export type ApiEventsResponse = { data: ApiEventRow[] };
export type ApiEventResponse = { data: ApiEventRow };

export async function fetchEventsList(): Promise<ApiEventRow[]> {
  const json = await apiFetch<ApiEventsResponse>('/events');
  return json.data ?? [];
}

export async function fetchEventBySlug(slug: string): Promise<ApiEventRow> {
  const json = await apiFetch<ApiEventResponse>(`/events/${encodeURIComponent(slug)}`);
  return json.data;
}

export type BookEventResponse = {
  success: boolean;
  message?: string;
  data?: {
    booking_reference: string;
    confirmation_url: string;
  };
  errors?: Record<string, string[]>;
};

export async function bookEvent(
  numericEventId: number,
  payload: Record<string, unknown>,
): Promise<BookEventResponse> {
  return apiFetch<BookEventResponse>(`/events/${numericEventId}/book`, {
    method: 'POST',
    body: JSON.stringify(payload),
  });
}

export type ContactPayload = {
  first_name: string;
  last_name: string;
  email: string;
  phone?: string;
  subject: string;
  message: string;
};

export type ContactResponse = {
  success: boolean;
  message?: string;
  errors?: Record<string, string[]>;
};

export async function submitContact(payload: ContactPayload): Promise<ContactResponse> {
  return apiFetch<ContactResponse>('/contact', {
    method: 'POST',
    body: JSON.stringify(payload),
  });
}

export type SiteResponse = {
  data: {
    name: string;
    url: string;
    settings: Record<string, string>;
  };
};

export async function fetchSiteMeta(): Promise<SiteResponse['data']> {
  const json = await apiFetch<SiteResponse>('/site');
  return json.data;
}
