<?php
include 'db.php';

// Ensure user is logged in and is an admin
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header('Location: login.php');
    exit();
}

$version = $_POST['version'];
$release_date = $_POST['release_date'];
$description = $_POST['description'];

// Handle file upload
if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_name = $_FILES['file']['name'];
    $file_path = 'downloads/' . basename($file_name);
    
    // Move the uploaded file to the server
    if (move_uploaded_file($file_tmp, $file_path)) {
        // Insert version details into the database
        $sql = "INSERT INTO game_versions (version, release_date, description, file_path) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $version, $release_date, $description, $file_path);
        
        if ($stmt->execute()) {
            header('Location: admin.php');
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo 'Failed to upload file.';
    }
} else {
    echo 'No file uploaded or error during upload.';
}

$conn->close();
?>
