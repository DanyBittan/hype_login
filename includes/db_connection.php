<?php
require_once 'config.php';
$dbConnection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$usersData = $dbConnection->query("SELECT * FROM users");
if ($dbConnection->connect_error) {
    die("Connection failed: " . $dbConnection->connect_error);
}
print_r($usersData);
