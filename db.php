<?php
$host = "localhost"; // or your host
$user = "root";      // default for XAMPP
$pass = "";          // default for XAMPP
$db   = "todo_app";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
