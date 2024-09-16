<?php
include 'includes/header.php';
include 'db.php';

$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch user profile details
$sql_user = "SELECT * FROM users WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc();
} else {
    echo '<p>User not found.</p>';
    exit();
}
?>

<section>
    <h2><?php echo htmlspecialchars($user['username']); ?>'s Profile</h2>
    
    <?php if (!empty($user['profile_picture'])): ?>
        <img src="uploads/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="<?php echo htmlspecialchars($user['username']); ?>'s Profile Picture" style="max-width: 200px; height: auto;">
    <?php else: ?>
        <p>No profile picture available.</p>
    <?php endif; ?>
    
    <p><strong>Bio:</strong> <?php echo nl2br(htmlspecialchars($user['bio'])); ?></p>
    
    <!-- Optionally, display a link to the user's threads or other related content -->
    <a href="user_threads.php?id=<?php echo htmlspecialchars($user_id); ?>">View User's Threads</a>
</section>

<?php include 'includes/footer.php'; ?>
