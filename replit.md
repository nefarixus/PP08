# SideQuest VR Platform — Laravel 10 + Vue 3

## Project Overview
A VR games store / library platform (SideQuest clone). Built with Laravel 10 backend (REST API) and Vue 3 SPA frontend. The user runs this locally via OSPanel + VS Code (not on Replit).

## Architecture
- **Backend**: Laravel 10, PHP 8.x, MySQL
- **Frontend**: Vue 3 + Vite SPA (TypeScript)
- **Auth**: Laravel Sanctum (SPA / cookie-based session authentication)
- **CSS**: Single global `styles/style.css` imported in `resources/js/app.js`
- **Entry**: `resources/views/app.blade.php` → `resources/js/app.js` → `resources/js/components/App.vue`

## Directory Structure
```
app/
  Http/Controllers/
    AuthController.php      — register, login
    UserController.php      — /api/user, /api/logout
    ProductController.php   — /api/products, /api/products/:id
    LibraryController.php   — /api/user/library (GET), /api/library (POST, free products)
    CheckoutController.php  — /api/checkout (POST, paid products)
  Models/
    User.php       — timestamps disabled (no created_at/updated_at in real DB)
    Product.php    — timestamps disabled
    UserProduct.php— timestamps disabled
    Order.php      — timestamps disabled (orders.created_at handled by MySQL DEFAULT)
routes/
  api.php         — all API routes under EnsureFrontendRequestsAreStateful
  web.php         — catch-all → app.blade.php
resources/
  js/
    app.js              — entry point, mounts Vue app
    utils/api.js        — CSRF-aware fetch helpers (apiGet, apiPost)
    router/index.js     — Vue Router routes
    components/App.vue  — root component (sidebar, footer)
    views/
      Home.vue      — full homepage (hero slider, catalog, card-menu, tops, last-container)
      Product.vue   — product detail (pd-wrap, pd-card, pd-btn classes)
      Library.vue   — user profile / library page (game-grid layout)
      Login.vue     — login form (login-footer INSIDE login-container)
      Register.vue  — registration form (same structure as Login)
      Checkout.vue  — checkout page (checkout-card__ BEM classes)
  views/app.blade.php  — Blade template, loads Vite bundle
styles/style.css        — single global stylesheet (DO NOT add scoped CSS for main pages)
```

## Database Notes
The real database (MySQL, managed by OSPanel) was created from the original PHP project SQL dump:
- `users` — id, login, email, password, role (NO timestamps)
- `products` — id, name, description, price, img (NO timestamps)
- `user_products` — id, user_id, product_id, added_at (DEFAULT CURRENT_TIMESTAMP; UNIQUE on user_id+product_id)
- `orders` — id, user_id, status, total, created_at (DEFAULT CURRENT_TIMESTAMP)
- `order_items` — id, order_id, product_id, price_at_purchase

All models must have `public $timestamps = false;` because the real DB doesn't have created_at/updated_at except where noted.

## CSRF / Auth
- All POST requests use `apiPost()` from `resources/js/utils/api.js`
- This utility calls `GET /sanctum/csrf-cookie` if needed, then reads the `XSRF-TOKEN` cookie and sends `X-XSRF-TOKEN` header
- Session driver: `file` (set in env)

## CSS Class Conventions
- Product detail page: `.pd-wrap`, `.pd-card`, `.pd-hero`, `.pd-panel`, `.pd-title`, `.pd-desc`, `.pd-actions`, `.pd-btn`, `.pd-btn-primary`, `.pd-btn-secondary`, `.pd-price-badge`
- Checkout page: `.checkout-page`, `.checkout-card`, `.checkout-card__media`, `.checkout-card__body`, `.checkout-price-badge`, `.checkout-btn`, `.checkout-err`
- Catalog cards: `.catalog-card`, `.catalog-card__link`, `.catalog-card__media`, etc.
- Library/Profile: `.profile-container`, `.profile-avatar`, `.game-grid`, `.game-card`
- Login/Register: `.main-login`, `.login-container`, `.login-footer` (INSIDE login-container), `.btn-login`, `.social-icons`
- Footer: `.site-footer`, `.site-footer__left`, `.site-footer__right`, `.site-footer__social`

## Key Decisions
- Footer is rendered inside `App.vue` (below `<router-view>`) to appear on all pages
- `Library.vue` serves both `/library` and `/profile` routes
- `App.vue` sidebar "Мой аккаунт" links to `/library`
- Free products: added via `POST /api/library`
- Paid products: checkout via `POST /api/checkout` (creates order + adds to library atomically)
