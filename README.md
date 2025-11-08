# Hype Login

## Setup

Clone or copy the project to your web root (/var/www/html/ or htdocs/).

Create a database (e.g. hype_test) and import the schema:
```
 mysql -u root -p hype_test < schema.sql
```

Copy the example config file and update credentials:
```
 cp includes/config.example.php includes/config.php
```

Then edit includes/config.php with your DB name, user, and password.

Access the app in your browser:
```
 http://localhost/hype_login/signup.php
```

## Security Highlights

Passwords hashed with `password_hash()`

CSRF tokens for all forms

XSS prevention via `htmlspecialchars()`

Prepared SQL statements (no concatenation)

Secure session cookies (httponly, samesite=Lax)

Content Security Policy: default-src 'self'

## Usage

Go to /signup.php → create a new account

Log in via /login.php

After successful login → view the list of users
