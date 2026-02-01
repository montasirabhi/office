# Login Backend (PHP)

PHP backend for the MSKS login flow. Scripts are named to match the Login pages: **login.php**, **forgot.php**, **otp.php**, **reset.php**.

---

## Files

| File        | Role |
|------------|------|
| **login.php**  | POST username + password → validate against `users`, set session, redirect to Login |
| **forgot.php** | POST email → generate 6-digit OTP, insert into `otp_codes`, send email, redirect to `Login/otp.php?email=...` |
| **otp.php**    | POST email + otp → verify in `otp_codes`, set `$_SESSION['reset_email']`, redirect to `Login/reset.php` |
| **reset.php**  | POST new_password + confirm_password (email from session) → update `users.password_hash`, redirect to `Login/login.php` |
| **init.php**   | `session_start()`, `getDb()`, `redirect()`, `setFlash()` / `getFlash()` |

---

## Config

- **config/database.php** – Loads DB constants, defines `getDb()` (PDO).  
- **config/config.example.php** – Copy to **config.php** and set `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`. Do not commit `config.php` if it contains secrets.

---

## Database

Requires tables from **database/schema.sql**: `users` (id, email, password_hash, name, ...) and `otp_codes` (email, code, expires_at, used_at).

---

## Frontend (Login/)

| Page            | Form action              |
|-----------------|---------------------------|
| login.php       | ../login-backend/login.php |
| forgot.php      | ../login-backend/forgot.php |
| otp.php         | ../login-backend/otp.php   |
| reset.php       | ../login-backend/reset.php |

All backend scripts redirect back to the appropriate `Login/*.php` page with flash messages on error or success.
