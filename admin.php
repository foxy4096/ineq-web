<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Check if the user is an admin
// For demonstration purposes, let's assume user ID 1 is an admin
if ($_SESSION['user_id'] != 1) {
    echo 'Access denied.';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="forum.php">Forum</a></li>
                <li><a href="download.php">Download</a></li>
                <li><a href="admin.php">Admin Panel</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Upload New Game Version</h2>
        <form action="upload_version.php" method="post" enctype="multipart/form-data">
            <label for="version">Version:</label>
            <input type="text" id="version" name="version" required>
            <br>
            <br>
            <label for="release_date">Release Date:</label>
            <input type="date" id="release_date" name="release_date" required>
            <br>
            <br>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            <br>
            <br>
            <label for="file">Game File:</label>
            <input type="file" id="file" name="file" accept=".zip,.rar,.exe" required>
            <br>
            <br>
            <button type="submit">Upload Version</button>
        </form>

        <h2>Manage Existing Versions</h2>
        <?php
        include 'db.php';
        
        $sql = "SELECT * FROM game_versions ORDER BY release_date DESC";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="version">';
                echo '<h4>Version: ' . htmlspecialchars($row['version']) . '</h4>';
                echo '<p>Release Date: ' . htmlspecialchars($row['release_date']) . '</p>';
                echo '<p>Description: ' . htmlspecialchars($row['description']) . '</p>';
                echo '<p>File: <a href="' . htmlspecialchars($row['file_path']) . '" download>Download</a></p>';
                echo '<a href="delete_version.php?id=' . $row['id'] . '">Delete</a>';
                echo '</div>';
            }
        } else {
            echo '<p>No versions available.</p>';
        }
        ?>
    </main>
</body>
</html>
