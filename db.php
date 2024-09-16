<?php
$servername = "localhost"; // Change this if your database is on a different server
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "ineq"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
