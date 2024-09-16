<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = htmlspecialchars($_POST['username']);
        $message = htmlspecialchars($_POST['message']);
        // Here you would normally save the data to a database
        // For now, let's just redirect back to the forum page
        header("Location: forum.php");
        exit();
    }
?>
