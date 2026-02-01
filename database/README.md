# Database

Database assets for the MSKS Office System. Used by **login-backend** for authentication and password reset.

---

## Schema

**schema.sql** – Run once in MySQL/MariaDB to create:

- **admins** – Admin users: id, email, password_hash, name, created_at, updated_at  
- **users** – Regular users: id, email, password_hash, name, created_at, updated_at  
- **otp_codes** – Password reset OTPs: id, email, **user_type** (admin|user), code, expires_at, used_at, created_at  

Login checks **admins** first, then **users**. Forgot-password and reset use `user_type` so the correct table is updated.

---

## Seeded accounts

After running **schema.sql**, two accounts exist (default password: **password**):

| Role  | Email             | Table  |
|-------|-------------------|--------|
| Admin | admin@msks.local  | admins |
| User  | user@msks.local   | users  |

Use these to sign in. To add more admins or users, insert into `admins` or `users` with a `password_hash` from PHP:

```php
password_hash('your_password', PASSWORD_DEFAULT);
```

---

## Login-backend connection

The **login-backend** uses `login-backend/config/database.php` (and optional **config/config.php**) for PDO connection. Set DB_HOST, DB_NAME, DB_USER, DB_PASS to match this database.
