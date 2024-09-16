<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ineq</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Welcome to Ineq</h1>
        <nav>
            <ul
                style="display: flex; gap: 20px; padding: 0; list-style: none;">
                <li><a href="index.php">Home</a></li>|
                <li><a href="download.php">Download</a></li>|
                <li><a href="forum.php">Forum</a></li>|
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php">Profile</a></li>|
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>|
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>