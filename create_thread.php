<?php
include 'db.php';

// Ensure user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$title = $_POST['title'];
$user_id = $_SESSION['user_id'];

$sql = "INSERT INTO threads (title, user_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $title, $user_id);

if ($stmt->execute()) {
    header('Location: forum.php');
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
