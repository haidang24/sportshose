# GIAYTHETHAO - E-commerce Shoes Store

A full-stack PHP e-commerce web app for selling shoes with modern UX, PayPal payments, order management, and admin dashboard.

## Features
- User authentication, profile, saved addresses
- Product catalog with brands, sizes, variants, search/filter
- Cart, checkout, and multiple payments (COD, PayPal)
- Order lifecycle: pending, shipping, delivered, cancelled
- Order history, details, cancel (restrictions for PayPal)
- Comments/reviews with image upload
- Admin: products, users, orders, statistics
- Email notifications via PHPMailer

## Tech Stack
- PHP 7+/8, PDO (MariaDB/MySQL)
- Frontend: Bootstrap 5, jQuery
- Payments: PayPal Orders v2 (Sandbox/Live)
- Mail: PHPMailer

## Requirements
- XAMPP (Apache, PHP, MySQL/MariaDB)
- Composer (optional for PHPMailer updates)

## Quick Start
1. Clone or extract into your web root (e.g. `htdocs/GIAYTHETHAO-main`).
2. Create database and import schema:
   - Import `web.sql` (or `ecoshop.sql`) into MariaDB.
3. Configure database in `Model/DBConfig.php`:
```php
// Example
private $servername = 'localhost';
private $dbname = 'ecoshop';
private $username = 'root';
private $password = '';
```
4. Configure PayPal in `config/paypal.php`:
```php
define('PAYPAL_MODE', 'sandbox'); // or 'live'
define('PAYPAL_CLIENT_ID', 'YOUR_CLIENT_ID');
define('PAYPAL_SECRET', 'YOUR_SECRET');
define('PAYPAL_CURRENCY', 'USD');
// Exchange rate VND->USD for server-side total calculation
define('EXCHANGE_RATE_VND_TO_USD', 26000);
```
5. Start Apache and MySQL in XAMPP. Visit `http://localhost/GIAYTHETHAO-main/index.php`.

## PayPal Setup
- Set client ID/secret (Sandbox or Live).
- The flow uses server-created orders and client-side capture, then server `capture` endpoint persists the order.
- Idempotency: `ORDER_ALREADY_CAPTURED` is treated as success and still persists order.
- After success, cart is cleared via `Controller/paypal.php?act=clear_cart`.

## Important Paths
- Controllers: `Controller/`
- Models: `Model/`
- Views: `View/`
- Assets: `View/assets/`
- AJAX scripts: `ajax/`

Key controllers:
- `Controller/paypal.php`: PayPal, COD flow
- `Controller/order_history.php`: Order history APIs
- `Controller/checkout.php`: Save shipping info to session
- `Controller/Admin/*`: Admin endpoints

## Environment and Sessions
- Session stores user info (`user_id`, `fullname`, `address`, location IDs) and `cart`.
- For order history, `Controller/order_history.php` falls back to `$_SESSION['user_id']` if POST `user_id` is missing.

## Database Notes
- Main tables: `product`, `details_product`, `size`, `orders`, `details_order`, `users`, `brand`, `shoes_type`, `goods_sold`.
- Order totals are aggregated from `details_order.total_price` and grouped by order.

## Common Tasks
- Change header/footer: `View/header.php`, `View/footer.php`
- Hide "Mua hàng ngay" on product detail: `View/details_product.php` (`#buy_now` hidden with `d-none`).
- Contact page (redesigned): `View/contact.php`; JS `ajax/Contact.js`; controller `Controller/contact.php`.

## Development
- Debug logs use `error_log()`; view PHP error log via Apache/PHP logs.
- Admin Dashboard under `View/Admin/` and `Controller/Admin/`.

## Security
- Queries use simple concatenation in legacy areas; avoid raw input. Where updated, inputs are trimmed/validated.
- Consider adding prepared statements and CSRF tokens for production hardening.

## Deployment
- Point Apache VirtualHost to project root.
- Set `PAYPAL_MODE='live'` and live credentials.
- Ensure `mail/setup.php` is configured with SMTP.

## Troubleshooting
- Orders not in history: ensure session `user_id` is set during checkout.
- PayPal `ORDER_ALREADY_CAPTURED`: handled as success; page reload should show order.
- Missing images: see `View/assets/img/placeholder.jpg` and provided scripts to create placeholders.

## License
This project is for educational/demo purposes. Customize as needed for production.
