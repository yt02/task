<?php
$servername = "localhost";
$username = "root";
$password = ""; // Leave blank for XAMPP default
$database = "web_app_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
