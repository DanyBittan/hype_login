<?php
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self'; connect-src 'self'; font-src 'self'; frame-ancestors 'none'; base-uri 'self'; form-action 'self';");
require_once 'includes/db_connection.php';
require_once 'includes/functions.php';

$username = $_POST['username'];
$password = $_POST['password'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF token validation
    if (!validateCsrfToken($_POST['csrf_token'])) {
        die('Invalid CSRF token');
    }
    // Prepare and execute the query to fetch user data
    $stmt = $dbConnection->prepare("SELECT id, password_hash FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verify password and create session
    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username;
            $_SESSION['logged_in'] = true;
            header("Location: usersView.php");
            exit;
        } else {
            header("Location: error.php?error=" . urlencode("Invalid password."));
            exit;
        }
    } else {
        header("Location: error.php?error=" . urlencode("Username not found."));
        exit;
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Login</title>
</head>

<body>
    <div>
        <form class="login-form" action="login.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
            <label for="username">Username:</label>
            <input type="text" name="username" placeholder="Username" required>
            <label for="password">Introduce your password:</label>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Log in</button>
            <a href="signup.php">You dont have an account? sign up</a>
        </form>
    </div>
</body>

</html>