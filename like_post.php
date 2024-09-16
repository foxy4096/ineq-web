<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'];
$action = $_POST['action'];

// Determine the query based on the action
if ($action === 'like') {
    $query = "INSERT INTO likes (post_id, user_id) VALUES (?, ?)";
} elseif ($action === 'unlike') {
    $query = "DELETE FROM likes WHERE post_id = ? AND user_id = ?";
} else {
    die('Invalid action');
}

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();
$stmt->close();

// Fetch the thread_id from the posts table
$stmt = $conn->prepare("SELECT thread_id FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

// Redirect back to the thread page
header('Location: view_thread.php?id=' . $row['thread_id']);
exit();
