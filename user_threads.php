<?php
include 'includes/header.php';
include 'db.php';

$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch threads created by the user
$sql_threads = "SELECT * FROM threads WHERE user_id = ? ORDER BY created_at DESC";
$stmt_threads = $conn->prepare($sql_threads);
$stmt_threads->bind_param("i", $user_id);
$stmt_threads->execute();
$result_threads = $stmt_threads->get_result();
?>

<section>
    <h2>Threads by User</h2>
    <?php if ($result_threads->num_rows > 0): ?>
        <?php while ($row_thread = $result_threads->fetch_assoc()): ?>
            <div class="thread">
                <h3><a href="view_thread.php?id=<?php echo htmlspecialchars($row_thread['id']); ?>">
                    <?php echo htmlspecialchars($row_thread['title']); ?>
                </a></h3>
                <p>Created on <?php echo htmlspecialchars($row_thread['created_at']); ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No threads created by this user.</p>
    <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>
