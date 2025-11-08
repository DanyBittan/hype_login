<?php

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'database_name');
define('DB_USER', 'database_user');
define('DB_PASS', 'CHANGE_ME');
// Application settings
define('APP_NAME', 'Hype Secure Login');
define('APP_URL', 'http://localhost/hype_test/');

// --- Security headers ---
if (!headers_sent()) {
    header("Content-Security-Policy: default-src 'self'");
    header("X-Frame-Options: DENY");
    header("X-Content-Type-Options: nosniff");
    header("Referrer-Policy: no-referrer-when-downgrade");
}
