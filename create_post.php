<?php
include 'db.php';

// Ensure user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$content = $_POST['content'];
$thread_id = $_POST['thread_id'];
$user_id = $_SESSION['user_id'];

$sql = "INSERT INTO posts (thread_id, user_id, content) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $thread_id, $user_id, $content);

if ($stmt->execute()) {
    header('Location: view_thread.php?id=' . $thread_id);
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
