# Office (MSKS)

Web Office System for NGO – MSKS.

**01 Feb 2026** – Login flow with PHP backend (Login, Forgot Password, OTP, Reset Password).

---

## Project structure

```
office/
├── Login/                 # All login-related pages (PHP + same Neumorphism style)
│   ├── login.php          # Login
│   ├── forgot.php         # Forgot Password (request OTP)
│   ├── otp.php            # OTP verification
│   ├── reset.php          # Reset Password
│   └── login.css          # Shared styles
│
├── login-backend/         # PHP backend: login, forgot, OTP, reset
│   ├── login.php          # Process login
│   ├── forgot.php         # Send OTP
│   ├── otp.php            # Verify OTP
│   ├── reset.php          # Update password
│   ├── init.php           # Session + DB bootstrap
│   ├── config/
│   │   ├── database.php   # PDO connection
│   │   └── config.example.php
│   └── README.md
│
├── database/              # Schema and DB assets
│   ├── schema.sql         # users, otp_codes tables
│   └── README.md
│
├── ReadME/
│   └── login.md
├── LICENSE
└── README.md
```

---

## Login flow

1. **Login** (`Login/login.php`) – Username/email + password → `login-backend/login.php` → session  
2. **Forgot Password** (`Login/forgot.php`) – Email → `login-backend/forgot.php` → OTP email → OTP page  
3. **OTP** (`Login/otp.php`) – 6-digit OTP → `login-backend/otp.php` → session reset token → Reset page  
4. **Reset Password** (`Login/reset.php`) – New password → `login-backend/reset.php` → Login  

---

## How to run

1. **Database** – Create a MySQL/MariaDB database and run `database/schema.sql`.  
2. **Config** – Copy `login-backend/config/config.example.php` to `login-backend/config/config.php` and set DB_HOST, DB_NAME, DB_USER, DB_PASS.  
3. **Web server** – Serve the project with PHP (e.g. Apache, Nginx+PHP-FPM, or `php -S localhost:8000` in project root).  
4. Open `Login/login.php` in the browser and use “Forgot Password?” to test the full flow.

Optionally add a test user (see comment in `database/schema.sql`) or insert one with a `password_hash()` from PHP.
