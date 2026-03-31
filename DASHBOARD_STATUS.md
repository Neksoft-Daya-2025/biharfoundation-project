# Dashboard – What’s Done vs What Remains

## ✅ Complete

| Area | Features |
|------|----------|
| **Home** | Real stats (visitors 30d, total orders, pending orders, revenue this month, **products count**), Quick Actions (Analytics, Customers, Orders, Products, Blog, Settings), System info |
| **Analytics** | Stats (total visits, unique, today), Visitor map (Leaflet), Visits chart, Top pages chart, Recent visitors table with date filter; session auth (no URL token) |
| **Orders** | List with search & filters (status, payment), **page number links** + Next/Previous, View order detail, Update status, API for list |
| **Products** | List, Create, Edit, View (read-only), Delete, Bulk select + View/Edit/Delete, Bulk delete |
| **Customers** | List from orders (and reservations if model exists), search, Export CSV, stats cards; copy “From orders”, **currency symbol** for Total Value, **Order** type badge |
| **Settings** | General (currency), SMTP (load/save/test), **Payment (Mollie load + save)**, Cache clear, **Date & Time** (timezone, format, business hours) |
| **Notifications** | List, filter, mark read, mark all read, delete, clear read/all; header badge; created on new order and new event booking |
| **Events** | Full CRUD, image upload or URL, publish/draft/cancel; **ticket types & seats** per event; **event bookings / attendees** (list, confirm/cancel) |
| **Blog** | Full CRUD (dashboard) via BlogController and BlogPost |
| **Auth** | Login with `ADMIN_EMAIL` / `ADMIN_PASSWORD` from `.env`, logout, session 24h, AdminAuth middleware |
| **Layout** | Sidebar (Dashboard, Analytics, Orders, Products, Customers, Notifications, Events, Blog, Settings), logout |
| **Public** | Root redirects to dashboard or login; `/theme-preview` shows active theme; `/events` list and `/events/{slug}` booking; **visitor tracking** via `GET /api/track` (theme layouts call it) |

---

## ⚠️ What remains (optional / deployment)

- **Mollie live:** Payment settings are loaded when you open the Payment tab and saved in the DB. Actual payments use `MOLLIE_KEY` from `.env`. Set `MOLLIE_KEY` in `.env` on the server for live payments (see `.env.example` and DEPLOYMENT_CHECKLIST.md).
- **Visitor tracking:** Implemented. Theme layouts call `GET /api/track?url=...` so analytics and map get data. No further work required unless you add more public pages outside the theme.
- **Documentation:** PROJECT_DISSECTION.md and this file list current routes, models, and dashboard sections (including Notifications, Events, ticket types & attendees, Date & Time, Blog).

---

## Summary

- **Core dashboard is complete:** home (with products card), analytics (with map, no auth token in URLs), orders (with page numbers), products (with bulk actions), customers (currency + Order badge), settings (general, SMTP, **Payment load/save**, cache, **Date & Time**), **Notifications**, **Events** (CRUD, ticket types, attendees), **Blog** (CRUD), and auth.
- **Visitor tracking** is in place via `/api/track`; theme layouts record visits.
- **Remaining:** Set `MOLLIE_KEY` in `.env` for production payments; docs are up to date.
