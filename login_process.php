<?php
include 'db.php';

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// Query to get the user
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['user_id'] = $user['id'];
    header('Location: forum.php');
} else {
    echo 'Invalid credentials.';
}

$stmt->close();
$conn->close();
?>
