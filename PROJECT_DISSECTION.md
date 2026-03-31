# Project Dissection (Dashboard-only)

A Laravel 12 app that serves **only the admin dashboard**. No public site: visiting `/` redirects to login or dashboard.

---

## 1. What the project is

| Aspect | Details |
|--------|---------|
| **Name** | Malbi's Kitchen |
| **Stack** | Laravel 12, PHP 8.2+, Blade, Vite |
| **Purpose** | Restaurant/food site: menu (products), cart, checkout, payments (Mollie), contact, and admin dashboard |
| **Auth** | Session-based admin login (env credentials), no customer accounts |

---

## 2. Directory layout (high level)

```
laravel-backend/
├── app/
│   ├── Http/Controllers/   # All request handlers
│   ├── Http/Middleware/    # AdminAuth
│   ├── Models/             # Eloquent models
│   └── Providers/
├── bootstrap/app.php       # App bootstrap, middleware aliases
├── config/                 # Laravel config
├── database/
│   ├── migrations/         # DB schema
│   ├── seeders/
│   └── factories/
├── public/                 # Web root, assets (CSS/JS/images)
├── resources/views/        # Blade templates
├── routes/
│   ├── web.php            # Public + cart + order + payment routes
│   └── dashboard-routes.php # Login, dashboard, API (settings, analytics, customers)
├── storage/
└── composer.json
```

---

## 3. Routes

### 3.1 Root

| Route | Purpose |
|-------|---------|
| `GET /` | Redirect to dashboard (if logged in) or login. Named `home` for compatibility. |

Theme preview and public events are available; other public site routes (home, services, cart, checkout, order, payment) exist only as theme views and are reachable via `/theme-preview` or if you add routes.

| Route | Purpose |
|-------|---------|
| `GET /theme-preview` | Show active theme home view (no auth). |
| `GET /api/track` | Record a page visit for analytics (public; call from theme). |
| `GET /events` | Public events list (published, upcoming). |
| `GET /events/{slug}` | Event detail + booking form. |
| `POST /events/{event}/book` | Create event booking. |
| `GET /events/booking/{reference}` | Booking confirmation. |

### 3.2 Auth & dashboard (dashboard-routes.php)

**Public auth (no middleware)**

| Route | Handler | Purpose |
|-------|---------|---------|
| `GET /login` | AuthController@showLogin | Login form |
| `POST /login` | AuthController@login | Login (session) |
| `POST /logout` | AuthController@logout | Logout |

**Protected** (prefix `dashboard`, middleware `web` + `admin.auth`)

| Route | Handler | Purpose |
|-------|---------|---------|
| `GET /dashboard` | DashboardController@index | Dashboard home (stats, quick actions) |
| `GET /dashboard/analytics` | AnalyticsController@index | Analytics page |
| `GET /dashboard/settings` | SettingsController@index | Settings (General, SMTP, Payment, Cache, Date & Time) |
| `GET /dashboard/customers` | CustomerController@index | Customers page |
| `GET /dashboard/orders` | OrderController@index | Orders list |
| `GET /dashboard/orders/{order}` | OrderController@show | Order detail |
| `POST /dashboard/orders/{order}/status` | OrderController@updateStatus | Update order status |
| `GET /dashboard/products` | ProductController@index | Products list |
| `GET /dashboard/products/create` | ProductController@create | Create product |
| `POST /dashboard/products` | ProductController@store | Store product |
| `GET /dashboard/products/{product}` | ProductController@show | Product detail |
| `GET /dashboard/products/{product}/edit` | ProductController@edit | Edit product |
| `PUT /dashboard/products/{product}` | ProductController@update | Update product |
| `DELETE /dashboard/products/{product}` | ProductController@destroy | Delete product |
| `POST /dashboard/products/bulk-delete` | ProductController@destroyBulk | Bulk delete products |
| `GET /dashboard/notifications` | NotificationController@index | Notifications page |
| `GET /dashboard/events` | EventController@index | Events list |
| `GET /dashboard/events/create` | EventController@create | Create event |
| `POST /dashboard/events` | EventController@store | Store event |
| `GET /dashboard/events/attendees` | EventController@attendees | All attendees |
| `GET /dashboard/events/{event}` | EventController@show | Event detail |
| `GET /dashboard/events/{event}/edit` | EventController@edit | Edit event |
| `PUT /dashboard/events/{event}` | EventController@update | Update event |
| `DELETE /dashboard/events/{event}` | EventController@destroy | Delete event |
| Event ticket types: create/edit/update/destroy | EventController | Ticket types per event |
| `POST /dashboard/events/bookings/{booking}/status` | EventController@updateBookingStatus | Confirm/cancel booking |
| `GET /dashboard/blog` | BlogController@index | Blog posts list |
| `GET /dashboard/blog/create` | BlogController@create | Create post |
| `POST /dashboard/blog` | BlogController@store | Store post |
| `GET /dashboard/blog/{post}/edit` | BlogController@edit | Edit post |
| `PUT /dashboard/blog/{post}` | BlogController@update | Update post |
| `DELETE /dashboard/blog/{post}` | BlogController@destroy | Delete post |

**Protected API** (prefix `api`, middleware `web` + `admin.auth`)

| Route | Purpose |
|-------|---------|
| `GET/POST /api/settings` | Get/update settings |
| `POST /api/clear-cache` | Clear cache |
| `GET/POST /api/smtp-config`, `POST /api/smtp-config/test` | SMTP config & test |
| `GET /api/analytics` | Analytics data |
| `GET /api/customers` | Customers list |
| `GET /api/customers/export` | Customers CSV export |
| `GET /api/orders` | Orders list (paginated, filters) |
| `GET /api/notifications`, unread-count, mark read, read-all, destroy, clear read/all | Notifications |
| `GET/POST /api/datetime`, `GET /api/datetime/timezones` | Date & Time settings |

---

## 4. Models & data

### 4.1 Models

| Model | Table | Role |
|-------|------|------|
| **User** | `users` | Laravel default; not used for admin (admin = env credentials + session) |
| **Product** | `products` | Menu items: name, description, price, category, image, allergens, is_available, sort_order |
| **Cart** | `carts` | One per session: session_id, items (JSON), subtotal, delivery_fee, total |
| **Order** | `orders` | Order header: customer_*, order_type, status, payment_*, mollie_payment_id, totals, delivery_* |
| **OrderItem** | `order_items` | Line items: order_id, product_id, product_name, price, quantity, subtotal |
| **Setting** | `settings` | Key/value (key, value, type, description). Helpers: `Setting::get()`, `Setting::set()` |
| **Visitor** | `visitors` | Analytics: ip, country, city, device, url, visited_at. Recorded via `GET /api/track`. |
| **Notification** | `notifications` | Dashboard notifications (e.g. new order, new event booking). |
| **Event** | `events` | Events: title, slug, description, image, dates, status (published/draft/canceled). |
| **EventTicketType** | `event_ticket_types` | Per-event ticket types (name, price, seats). |
| **EventBooking** | `event_bookings` | Bookings: event_id, customer_*, reference, status. |
| **EventBookingItem** | `event_booking_items` | Line items: booking_id, ticket_type_id, quantity, price. |
| **BlogPost** | `blog_posts` | Blog: title, slug, content, published_at, etc. |

### 4.2 Important relationships

- **Order** → hasMany **OrderItem**
- **OrderItem** → belongsTo **Order**, belongsTo **Product**
- **Product** → hasMany **OrderItem**

Cart stores product IDs and quantities in JSON; no Cart ↔ Product relation in DB.

### 4.3 Migrations (tables)

- `users`, `cache`, `jobs` (Laravel default)
- `visitors`, `settings`, `products`, `carts`, `orders`, `order_items`

---

## 5. Controllers (logic)

### 5.1 AuthController

- **Login**: Compare email/password to `ADMIN_EMAIL` and `ADMIN_PASSWORD` from `.env`. On success: `admin_logged_in` + `admin_login_time` in session.
- **Session**: Admin session expires after 24 hours (checked in middleware).
- No database user; no registration.

### 5.2 CartController

- **Cart per session**: One `Cart` row per `Session::getId()`.
- **Items**: JSON array of `{ product_id, quantity, price }`. Totals: subtotal from items; delivery fee €5 unless subtotal ≥ €50; total = subtotal + delivery_fee.
- **Endpoints**: add (merge quantity if same product), update quantity, remove by product_id, clear. All return JSON.

### 5.3 OrderController

- **checkout**: Requires non-empty cart for current session; shows checkout view with cart.
- **store**: Validates customer + order_type (delivery/pickup). Creates `Order` + `OrderItem`s from cart, then clears cart. Returns JSON with order_id and order_number (`MK-` + 8 random chars).
- **confirmation**: Shows confirmation view by `order_number`.

### 5.4 PaymentController (Mollie)

- **create**: Creates Mollie payment for order total (EUR), sets redirect + webhook URLs, stores `mollie_payment_id` on order. Returns JSON with checkout URL.
- **return**: After payment, Mollie redirects here. Fetches payment; if paid/pending updates order and redirects to confirmation or checkout with message.
- **webhook**: Mollie POSTs here. Finds order by `mollie_payment_id`, updates `payment_status` and `status` (e.g. paid / failed). Returns JSON for Mollie.

### 5.5 ContactController

- Validates: first_name, last_name, email, phone (optional), subject, message.
- Sends mail to admin (from `Setting::get('admin_email')` or default).
- Uses Blade view `emails.contact`; reply-to set to sender.

### 5.6 Dashboard controllers

- **DashboardController**: Home with stats (visitors 30d, orders, pending, revenue, products_count), quick actions, system info.
- **AnalyticsController**: Page + API using `Visitor::getStatistics($days)`; public `GET /api/track` records visits (used by theme layouts).
- **SettingsController**: Page + API for settings (get/update, clear cache), SMTP (get/save/test), Payment (Mollie), Date & Time.
- **CustomerController**: Page + API for customers list and CSV export (from orders and reservations if model exists).
- **OrderController** (Dashboard): Orders list/detail, update status, API (paginated, filters).
- **ProductController** (Dashboard): Products CRUD, bulk delete.
- **NotificationController**: Notifications list, mark read, read all, delete, clear; API and unread count.
- **EventController** (Dashboard): Events CRUD, ticket types, attendees, booking status.
- **BlogController** (Dashboard): Blog posts CRUD.
- **DateTimeController**: Date & Time settings API (timezone, format, business hours).

---

## 6. Middleware

- **admin.auth** (`App\Http\Middleware\AdminAuth`):
  - Requires `admin_logged_in` in session and 24h not exceeded.
  - Unauthorized: JSON 401 or redirect to `login` with error.

Dashboard and API routes use `web` + `admin.auth`.

---

## 7. Views (Blade)

- **Layouts**: `layouts/app.blade.php` (main), `layouts/dashboard.blade.php` (admin).
- **Components**: header, footer, sticky-header, cart-sidebar, cookie-consent.
- **Pages**: home, about, services, blog, contact, privacy, terms, checkout, order-confirmation.
- **Auth**: auth/login.
- **Dashboard**: dashboard, dashboard/analytics, dashboard/settings, dashboard/customers.
- **Emails**: emails/contact.

Assets: `public/assets/` (CSS, JS, images); referenced via `asset()`.

---

## 8. Config & env

- **App**: Standard Laravel config in `config/`.
- **Admin**: `ADMIN_EMAIL`, `ADMIN_PASSWORD` (used by AuthController).
- **Mollie**: Mollie API key (via Laravel config / env) for PaymentController.
- **Mail**: SMTP config (and dashboard SMTP settings) for contact form and future emails.

---

## 9. Flow summary

1. **Root `/`**: Redirects to dashboard (if logged in) or login.
2. **Public**: `/theme-preview` shows active theme home; `/events` and `/events/{slug}` for event list and booking; `GET /api/track` records visits when theme pages load.
3. **Admin**: Logs in with env credentials (`ADMIN_EMAIL`, `ADMIN_PASSWORD`) → dashboard. All dashboard/API routes protected by `admin.auth`.
4. **Dashboard**: Home (stats, quick actions), Analytics (visitors, map, charts), Orders (list, detail, status), Products (CRUD, bulk), Customers (list, CSV), Notifications, Events (CRUD, ticket types, attendees), Blog (CRUD), Settings (General, SMTP, Payment, Cache, Date & Time).

---

## 10. What remains (optional / deployment)

- **Mollie live**: Set `MOLLIE_KEY` in `.env` on the server for live payments; Payment tab in Settings loads/saves Mollie config.
- **Visitor tracking**: Implemented via `GET /api/track`; theme layouts call it so analytics/map get data.
- **Documentation**: PROJECT_DISSECTION and DASHBOARD_STATUS are kept in sync with routes, models, and dashboard sections.

---

## 11. Notable files to open next

| Goal | File(s) |
|------|--------|
| Change public routes | `routes/web.php` |
| Change dashboard/API routes | `routes/dashboard-routes.php` |
| Cart/order/payment logic | `app/Http/Controllers/CartController.php`, `OrderController.php`, `PaymentController.php` |
| Admin login logic | `app/Http/Controllers/AuthController.php`, `app/Http/Middleware/AdminAuth.php` |
| Data shape | `app/Models/*.php`, `database/migrations/*.php` |
| Main layout / pages | `resources/views/layouts/app.blade.php`, `resources/views/home.blade.php`, `resources/views/services.blade.php` |
| Checkout flow | `resources/views/checkout.blade.php`, `resources/views/order-confirmation.blade.php` |

This dissection should be enough to navigate and change any part of the project; use this file as the map.
