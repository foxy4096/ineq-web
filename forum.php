<?php include 'includes/header.php'; ?>
<?php include 'db.php' ?>

<h2>Forum</h2>

<section>
    <?php if (isset($_SESSION['user_id'])): ?>
        <h3>Create a New Thread</h3>
        <form action="create_thread.php" method="post">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            <button type="submit">Create Thread</button>
        </form>
    <?php else: ?>
        <h3>Please log in to create a new thread.</h3>
        <ul>

            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
    <?php endif; ?>

</section>

<section>
    <h3>Threads</h3>
    <?php
    $sql = "SELECT * FROM threads ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="thread">';
            echo '<h4><a href="view_thread.php?id=' . $row['id'] . '">' . htmlspecialchars($row['title']) . '</a></h4>';
            echo '<p>Created by User ID: <a href="public_profile.php?id=' . htmlspecialchars($row['user_id']) . '">' . sprintf('%04d',htmlspecialchars($row['user_id'])) . '</a> on ' . $row['created_at'] . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No threads available.</p>';
    }
    ?>
</section>

<?php include 'includes/footer.php'; ?>