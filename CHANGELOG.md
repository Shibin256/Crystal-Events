# Changelog - Crystal Events

All notable changes, bug fixes, and security enhancements implemented in Crystal Events are documented below.

---

## [Unreleased / fix/local-setup] - 2026-10-31

### Added
- **`config.php`**: Centralized configuration file declaring constants for database credentials, base URL, timezone, mock payments flag (`MOCK_PAYMENTS`), and Razorpay API credentials.
- **`database/crystal_events.sql`**: Full 12-table DDL relational schema (`utf8mb4`) with primary keys, foreign key constraints (`ON DELETE CASCADE`), indexes, and realistic seed data across all roles and booking states.
- **`users/admin/uploads/.htaccess`**: Directory security configuration denying direct execution of `.php`, `.phtml`, and script files.
- **`users/company/uploads/.htaccess`**: Directory security configuration denying direct execution of `.php`, `.phtml`, and script files.
- **`users/user/uploads/.htaccess`**: Directory security configuration denying direct execution of `.php`, `.phtml`, and script files.
- **`users/company/php/delete_event.php`**: Secure endpoint verifying company ownership before deleting an event.
- **`users/company/php/edit_event.php`**: Secure endpoint verifying company ownership before updating event details.
- **`README.md`**: Comprehensive documentation covering setup, architecture, credentials, payment flows, and security.

### Removed
- **`users/admin/uploads/bikes/`**: Deleted legacy motorcycle showroom images leftover from cloned repository.
- **`mail-templates/`**: Deleted unused legacy email templates referencing order deliveries and test drives.
- **`users/user/order.php`**: Deleted unused legacy bike showroom order page.
- **`users/user/invoice.php`**: Deleted unused legacy motorcycle invoice page.
- **`users/user/invoice2.php`**: Deleted unused legacy motorcycle invoice page.

### Security Remediations
- **SQL Injection (CWE-89)**:
  - Re-implemented `php/connect.php` helper functions (`sel`, `insert`, `update`, `delete`, `num`) with prepared statements and bound parameters.
  - Converted dynamic SQL concatenation across all user, company, admin, and authentication endpoints to parameterized queries.
  - Added strict parameter casting (integer and float casting for IDs and amounts).
- **Broken Access Control & Session Fixation (CWE-284, CWE-384)**:
  - Added `session_regenerate_id(true)` upon login.
  - Enforced role checking in session (`$_SESSION['usertype']`) in `users/admin/header.php` (`usertype = 1`), `users/user/header.php` (`usertype = 2`), and `users/company/header.php` (`usertype = 3`).
  - Replaced JavaScript `<script>window.location...` without exits with server-side HTTP 302 redirects (`header('Location: ...'); exit;`).
  - Added session and role checks returning HTTP 401/403 to every endpoint in `users/*/php/*`.
  - Added account ownership checks ensuring users and companies can only access, edit, or pay for their own records.
  - Added restriction for pending accounts (`status = 0`) confining them to `profile.php` and `password.php`.
- **Insecure File Uploads & RCE (CWE-434)**:
  - In `users/company/php/profile_pic.php`, `users/user/php/profile_pic.php`, and `users/company/php/gallery.php`:
    - Validated extensions against whitelist (`jpg`, `jpeg`, `png`, `webp`).
    - Validated actual file MIME type using PHP `finfo` (`FILEINFO_MIME_TYPE`).
    - Verified image dimensions with `getimagesize()`.
    - Enforced 5 MB maximum file size limit.
    - Generated randomized server-side filenames (`bin2hex(random_bytes(16)) . '.' . $ext`).
    - Removed old profile images when updating to prevent orphaned files.
- **Plaintext Passwords (CWE-256)**:
  - Migrated `php/signup.php` to use `password_hash($password, PASSWORD_BCRYPT)`.
  - Migrated `php/login.php` and all `passwordchange.php` files to use `password_verify()`.
  - Added automatic on-the-fly migration in `php/login.php` that upgrades legacy plaintext passwords to bcrypt on first successful login.
- **Cross-Site Scripting (XSS) (CWE-79)**:
  - Wrapped dynamic outputs across public pages, user dashboard, company dashboard, and admin dashboard with `safe_html()` (`htmlspecialchars($v, ENT_QUOTES, 'UTF-8')`).
- **Payment Manipulation & Double-Payment (CWE-20, CWE-362)**:
  - Milestone amounts (40% advance, 60% balance) are calculated strictly server-side based on the verified booking quotation.
  - Added state checks ensuring advance payment can only be paid when `pay_id1 = 0`, and balance payment can only be paid when `pay_id1 > 0` and `pay_id2 = 0`.
  - Added server-side Razorpay HMAC-SHA256 signature verification when `MOCK_PAYMENTS = false`.
  - Added seamless `MOCK_PAYMENTS` simulation mode for local development.

### Bug Fixes & Code Improvements
- **`php/connect.php`**:
  - Connected to database via `config.php` constants.
  - Added `mysqli_report(MYSQLI_REPORT_OFF)` to prevent unhandled database exceptions in PHP 8.1+.
  - Set database connection charset to `utf8mb4`.
  - Fixed malformed charset header in `send_mail` from `UISO-8859-1` to `UTF-8`.
- **`php/signup.php`**:
  - Fixed foreign key order: inserted parent `login` record before child `users` or `company` record.
- **`users/company/complaints.php`**:
  - Replaced query referencing nonexistent `customer` table with `users`.
  - Corrected column references (`first_name`/`last_name` &rarr; `firstname`/`lastname`, `email_id` &rarr; `email`).
- **`users/company/php/passwordchange.php`**:
  - Fixed column reference `email_id` to `email`.
  - Replaced incorrect `sel()` call with `update()`.
- **`users/company/addevents.php`**:
  - Removed broken `onsubmit="return check()"` JavaScript error referencing a nonexistent photo input.
- **`users/company/php/addevents.php`**:
  - Fixed typo in error message: replaced "Same Bike already exsists!!!" with clean event feedback.
  - Fixed role check from `usertype !== 2` to `usertype !== 3`.
- **`users/company/viewevents.php`**:
  - Removed dead motorcycle stock update modal and form that posted to non-existent `php/update_stock.php`.
  - Added interactive Edit Event and Delete Event modals with pre-filled inputs.
- **`users/company/gallery.php`**:
  - Added missing `id="photo"` attribute on file input.
  - Protected image URL outputs with `rawurlencode()`.
- **`users/company/index.php`**:
  - Replaced completely commented-out dashboard with real metrics: Total Events, Pending Enquiries, Approved Bookings, Completed Events, Booked Revenue, and Average Rating.
  - Added Recent Bookings overview table.
- **`users/admin/index.php`**:
  - Removed commented-out bike code.
  - Added real platform metrics: Users, Companies, Events, Bookings, Revenue, Messages, and Recent Bookings table.
- **`users/user/allevents.php` & `users/user/php/allevents.php`**:
  - Replaced N+1 query loop for cart status with a preloaded lookup map.
  - Parameterized keyword search and category filter queries.
- **`users/user/companies.php` & `users/user/php/companies.php`**:
  - Parameterized search query.
  - Fixed PHP 8.1+ deprecation of passing null to `substr()` on company `about` field using `safe_str()`.
- **`users/user/view.php`**:
  - Parameterized company details query.
  - Fixed potential division by zero when calculating star rating percentages for companies with no reviews.
- **`users/user/cart.php` & `users/user/php/cart.php`**:
  - Streamlined cart item fetching with `JOIN`.
  - Scoped item deletion strictly to logged-in user (`user = ?`).
  - Parameterized multi-item checkout insertion into `bookings`.
- **`users/user/book_approved.php`**:
  - Added mock payment integration in JavaScript.
  - Displayed formatted prices and payment status badges.
- **`users/user/complaint.php`**:
  - Fixed syntax error (unclosed brace in query loop).
- **`users/user/header.php` & `users/company/header.php`**:
  - Cleaned up leftover motorcycle CSS IDs (`id="bikes"` &rarr; `id="events"` and `id="companies"`).
  - Selected active district in profile editing dropdowns.
- **`index.php`**:
  - Protected public landing page company and review loops against null star values and unescaped strings.
