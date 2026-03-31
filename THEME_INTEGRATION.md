# Theme integration (Lovable → Laravel)

This app supports multiple **public-site themes**. The active theme is chosen in **Dashboard → Settings → General**. The dashboard UI does not change; only the public site (when you add routes back) uses the selected theme.

---

## How it works

- **Config:** `config/themes.php` lists available themes. Each has an `id`, `name` (label in dashboard), `views` (Blade path), and `assets` (path under `public/`).
- **Setting:** The key `active_theme` is stored in the settings table (e.g. `default`, `lovable`). Default when missing: `default`.
- **Helpers:**
  - `current_theme()` – active theme id.
  - `theme_view($name)` – view name for the current theme (e.g. `themes.lovable.home`).
  - `theme_asset($path)` – URL for an asset in the current theme (e.g. `themes/lovable/css/style.css`).

Use `theme_view()` and `theme_asset()` in **public** routes and their Blade layouts so switching theme works without changing route code.

---

## Adding a new theme (e.g. Lovable export)

1. **Create folders**
   - Views: `resources/views/themes/<theme_id>/`  
     Example: `resources/views/themes/lovable/`.
   - Assets: `public/themes/<theme_id>/`  
     Example: `public/themes/lovable/`.

2. **Copy your converted Blade views and assets**
   - Put Blade files under `resources/views/themes/<theme_id>/` (e.g. `home.blade.php`, `layouts/app.blade.php`, `contact.blade.php`).
   - Put CSS, JS, images under `public/themes/<theme_id>/` (e.g. `css/`, `js/`, `images/`).

3. **Register the theme in config**
   - Edit `config/themes.php` and add an entry:
   ```php
   'lovable' => [
       'name'   => 'Lovable',
       'views'  => 'themes.lovable',
       'assets' => 'themes/lovable',
   ],
   ```
   Use the same `theme_id` as the folder names.

4. **Select the theme in the dashboard**
   - Go to **Dashboard → Settings → General**.
   - Choose the new theme in **Active theme** and click **Save General Settings**.

---

## Using the theme in public routes

When you add public routes (e.g. home, contact):

- **Render views:** `return view(theme_view('home'))` or `return view(theme_view('contact'))`.  
  This resolves to the active theme’s view (e.g. `themes.lovable.home`).

- **In theme Blade layouts:** reference assets with `theme_asset()`:
  - `<link href="{{ theme_asset('css/style.css') }}" rel="stylesheet">`
  - `<script src="{{ theme_asset('js/main.js') }}"></script>`
  - `<img src="{{ theme_asset('images/logo.png') }}" alt="Logo">`

Use consistent view names (e.g. `home`, `contact`, `layouts.app`) across themes so the same route code works for any theme.

---

## Folder convention summary

| Purpose   | Path |
|----------|------|
| Theme views | `resources/views/themes/{theme_id}/` |
| Theme assets | `public/themes/{theme_id}/` |

Example for theme id `lovable`:
- `resources/views/themes/lovable/home.blade.php` → `theme_view('home')`
- `public/themes/lovable/css/style.css` → `theme_asset('css/style.css')`
