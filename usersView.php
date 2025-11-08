<?php
require_once 'includes/db_connection.php';
session_start();
// Check if the session is up
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Users</title>
</head>

<body>
    <?php echo "<h2>Welcome, " . htmlspecialchars($_SESSION['username']) . "!</h2>"; ?>
    <img src="includes/hype_banner.png" alt="banner" width="40%" ">
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
        </tr>
        <tr>
            <?php
            while ($row = $usersData->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tr>
    </table>
    <a href=" logout.php">
    <h2>LOGOUT</h2>
</body>

</html>