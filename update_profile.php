<?php
session_start();
include 'db.php';

$user_id = $_POST['user_id'];
$username = $_POST['username'];
$email = $_POST['email'];
$bio = $_POST['bio'];

// Validate input
if (empty($username) || empty($email)) {
    die('Username and email are required.');
}

// Handle profile picture upload
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    $tmp_name = $_FILES['profile_picture']['tmp_name'];
    $name = basename($_FILES['profile_picture']['name']);
    $upload_file = $upload_dir . $name;

    // Check if file is an image
    $check = getimagesize($tmp_name);
    if ($check === false) {
        die('File is not an image.');
    }

    // Move the uploaded file
    if (!move_uploaded_file($tmp_name, $upload_file)) {
        die('Failed to upload file.');
    }

    // Update the profile picture path in the database
    $sql_update = "UPDATE users SET username = ?, email = ?, bio = ?, profile_picture = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssi", $username, $email, $bio, $name, $user_id);
} else {
    // Update user profile without changing the profile picture
    $sql_update = "UPDATE users SET username = ?, email = ?, bio = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssi", $username, $email, $bio, $user_id);
}

if ($stmt_update->execute()) {
    header('Location: profile.php');
    exit();
} else {
    die('Error updating profile: ' . $stmt_update->error);
}
