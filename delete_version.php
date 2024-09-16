<?php
include 'db.php';

// Ensure user is logged in and is an admin
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header('Location: login.php');
    exit();
}

$version_id = $_GET['id'];

// Get the file path from the database
$sql = "SELECT file_path FROM game_versions WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $version_id);
$stmt->execute();
$result = $stmt->get_result();
$version = $result->fetch_assoc();

if ($version) {
    // Delete the file from the server
    if (unlink($version['file_path'])) {
        // Delete the record from the database
        $sql = "DELETE FROM game_versions WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $version_id);

        if ($stmt->execute()) {
            header('Location: admin.php');
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo 'Failed to delete file.';
    }
} else {
    echo 'Version not found.';
}

$conn->close();
?>
