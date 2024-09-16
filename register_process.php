<?php
include 'db.php';

// Get form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Check if passwords match
if ($password !== $confirm_password) {
    echo 'Passwords do not match.';
    exit();
}

// Hash the password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insert new user into the database
$sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $email, $password_hash);

if ($stmt->execute()) {
    header('Location: login.php');
} else {
    echo 'Error: ' . $stmt->error;
}

$stmt->close();
$conn->close();
?>
