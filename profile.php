<?php
include 'includes/header.php';
include 'db.php';

$user_id = $_SESSION['user_id'];

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
    <h2>User Profile</h2>
    <form action="update_profile.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
        <br>
        <br>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        <br>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        <br>
        <br>
        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio"><?php echo htmlspecialchars($user['bio']); ?></textarea>
        <br>
        <br>
        <label for="profile_picture">Profile Picture:</label>
        <?php if (!empty($user['profile_picture'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" style="max-width: 200px; height: auto;">
            <br>
        <?php endif; ?>
        <input type="file" id="profile_picture" name="profile_picture">
        <br>
        <br>
        <button type="submit">Update Profile</button>
        <br>
        <br>
        <a href="public_profile.php?id=<?= $user['id']?>">View public profile</a>

    </form>
</section>

<?php include 'includes/footer.php'; ?>
