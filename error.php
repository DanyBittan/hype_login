<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Error login </title>
</head>

<body>

    <div class="error-card">
        <h1>Error during login</h1>
        <p>
            <?php
            if (isset($_GET['error'])) {
                echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8');
            } else {
                echo "An unknown error occurred.";
            }
            ?>
        </p>
    </div>
    <a href="login.php">
        <h2>GO BACK</h2>
    </a>
</body>

</html>