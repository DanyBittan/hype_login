<?php
require_once 'includes/db_connection.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_input($_POST['username']);
    $email_raw = $_POST['email'];
    $password = $_POST['password'];
    $passwordVerification = $_POST['password_verification'];

    // CSRF token validation
    if (!validateCsrfToken($_POST['csrf_token'])) {
        die('Invalid CSRF token');
    }

    // Validate input and check for existing user
    $errors = validateSignup($email_raw, $password, $passwordVerification);

    // Check if username or email already exists
    $email = sanitize_input($email_raw);
    $exists = userExists($dbConnection, $username, $email);
    if ($exists === 'username') {
        $errors[] = "Username already taken.";
    } elseif ($exists === 'email') {
        $errors[] = "Email already in use.";
    }

    if (!empty($errors)) {
        header("Location: signup.php?errors=" . urlencode(implode(", ", $errors)));
        exit;
    }

    // Hash the password and insert the new user into the database
    $hashPassword = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $dbConnection->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashPassword);
    $stmt->execute();
    $newUserId = $stmt->insert_id;
    $stmt->close();

    // Create a session for the new user
    $_SESSION['user_id'] = $newUserId; // el id autoincrement generado
    $_SESSION['username'] = $username;
    $_SESSION['logged_in'] = true;
    header("Location: usersView.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Sign up</title>


</head>

<body>
    <form class="signup-form" action="signup.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" placeholder="Username" required>
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Email" required>
        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Password" required>
        <label for="password_verification">Repeat the password:</label>
        <input type="password" name="password_verification" placeholder="Repeat the password" required>
        <button type="submit">Sign Up</button>
        <?php if (isset($_GET['errors'])) {
            echo '<div class="error-card">' . htmlspecialchars($_GET['errors'], ENT_QUOTES, 'UTF-8') . '</div>';
        } ?>
        <a href="login.php">Already have an account? Log in here.</a>
    </form>

</body>

</html>