<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'hype_test');
define('DB_USER', 'hype_user');
define('DB_PASS', 'password');

// Application settings
define('APP_NAME', 'Hype Secure Login');

// Start secure session
session_start();
session_regenerate_id(true);
