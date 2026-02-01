# Login – MSKS (Neumorphism UI)

Login flow for the MSKS Office System: **Login**, **Forgot Password**, **OTP**, and **Reset Password**. All pages are PHP and share the same Neumorphism style. Forms post to the **login-backend** PHP scripts.

---

## Features

- **Neumorphism (Soft UI)** – Same look on every login page  
- **Font Awesome** icons, **Google Font** (Poppins)  
- **PHP backend** – login.php, forgot.php, otp.php, reset.php in `login-backend/`  
- **Flash messages** – Error/success/info after redirects  
- **Session** – Login and reset flow use PHP sessions  

---

## Login folder structure

```
office/Login/
├── login.php      # Login form → ../login-backend/login.php
├── forgot.php     # Forgot form → ../login-backend/forgot.php
├── otp.php        # OTP form → ../login-backend/otp.php
├── reset.php      # Reset form → ../login-backend/reset.php
└── login.css      # Shared styles (+ flash message styles)
```

---

## Page flow

| Page            | File        | Form action                  | Links                          |
|-----------------|------------|------------------------------|--------------------------------|
| Login           | login.php  | login-backend/login.php      | Forgot Password? → forgot.php  |
| Forgot Password | forgot.php | login-backend/forgot.php     | Back to Login → login.php      |
| OTP             | otp.php    | login-backend/otp.php        | Resend → forgot.php, Back → login.php |
| Reset Password  | reset.php  | login-backend/reset.php      | Back to Login → login.php      |

---

## How to run

1. Configure the database (run `database/schema.sql`) and `login-backend/config/config.php`.  
2. Serve the project with PHP.  
3. Open `Login/login.php` and use “Forgot Password?” to go through Forgot → OTP → Reset → Login.
