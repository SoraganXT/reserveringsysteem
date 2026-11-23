# Reservation Platform

Lightweight reservation and preorder system for local stores, optimized for shared hosting and one.com.

## Setup

1. Upload the project to your hosting root (public_html or www).
2. Create a MySQL database and user.
3. Update database settings in `includes/config.php`.
4. Import `database.sql` into your database.
5. Run `scripts/seed.php` once to create demo users, then delete the file.
6. (Optional) Load one of the demo seeds from `seeds/` to switch between bakery, florist, or night shop examples.

## Demo accounts

- Admin: admin@demo.local / Admin123!
- Store owner: owner@demo.local / Owner123!

## Hosting notes (one.com / shared / VPS / dedicated)

- The project uses plain PHP and MySQL with no heavy dependencies.
- Ensure PHP 8.0+ and PDO MySQL extension are enabled.
- Set proper write permissions for `uploads/`.

## Project structure

- `index.php` public landing page
- `uitleg.php` product explainer page
- `store/` customer storefront and reservation flow
- `auth/` login/logout
- `dashboard/` store owner area
- `admin/` platform admin area
- `adminlogin.php` discreet staff entry
- `includes/` config and shared layout
- `css/` and `js/` front-end assets
- `uploads/` uploaded assets
- `database.sql` database schema and demo data
- `seeds/` demo data sets for bakery, florist, and night shop

## Next steps

- Add email notifications
- Add capacity checks for time slots
- Add product images and categories UI
- Add delivery/QR pickup modules

## Language

- Default language is Dutch.
- Switch to French by adding `?lang=fr` to any page URL.
