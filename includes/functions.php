<?php
// Start secure session
session_set_cookie_params([
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Lax'
]);
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clean and validate user input
function sanitize_input($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Validate signup form data
function validateSignup($email, $password, $passwordVerification)
{
    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }

    if ($password !== $passwordVerification) {
        $errors[] = "Passwords do not match.";
    }

    return $errors;
}

// Check if user already exists in the database
function userExists($conn, $username, $email)
{
    $stmt = $conn->prepare("SELECT username, email FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        if ($row['username'] === $username) {
            return 'username';
        }
        if ($row['email'] === $email) {
            return 'email';
        }
    }
    return false;
}

function generateCsrfToken()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCsrfToken($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
