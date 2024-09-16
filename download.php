<?php include 'includes/header.php'; ?>
<?php include 'db.php'; ?>

<h2>Download Ineq</h2>

<section>
    <h3>Latest Version</h3>
    <?php
    $latest_version = null; // Initialize the variable

    // Fetch the latest version
    $sql_latest = "SELECT * FROM game_versions ORDER BY release_date DESC LIMIT 1";
    $result_latest = $conn->query($sql_latest);
    
    if ($result_latest->num_rows > 0) {
        $latest_version = $result_latest->fetch_assoc();
        echo '<div class="version">';
        echo '<h4>Version: ' . htmlspecialchars($latest_version['version']) . '</h4>';
        echo '<p>Release Date: ' . htmlspecialchars($latest_version['release_date']) . '</p>';
        echo '<p>Description: ' . htmlspecialchars($latest_version['description']) . '</p>';
        echo '<a href="' . htmlspecialchars($latest_version['file_path']) . '" download>Download Latest Version</a>';
        echo '</div>';
    } else {
        echo '<p>No versions available.</p>';
    }
    ?>

    <h3>Other Versions</h3>
    <?php
    if ($latest_version) {
        // Fetch other versions, excluding the latest version
        $sql_other = "SELECT * FROM game_versions WHERE id != ? ORDER BY release_date DESC";
        $stmt_other = $conn->prepare($sql_other);
        $stmt_other->bind_param("i", $latest_version['id']);
        $stmt_other->execute();
        $result_other = $stmt_other->get_result();

        if ($result_other->num_rows > 0) {
            while ($row = $result_other->fetch_assoc()) {
                echo '<div class="version">';
                echo '<h4>Version: ' . htmlspecialchars($row['version']) . '</h4>';
                echo '<p>Release Date: ' . htmlspecialchars($row['release_date']) . '</p>';
                echo '<p>Description: ' . htmlspecialchars($row['description']) . '</p>';
                echo '<a href="' . htmlspecialchars($row['file_path']) . '" download>Download</a>';
                echo '</div>';
            }
        } else {
            echo '<p>No other versions available.</p>';
        }

        $stmt_other->close();
    } else {
        echo '<p>No other versions available.</p>';
    }
    ?>
</section>

<?php include 'includes/footer.php'; ?>
