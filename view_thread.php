<?php
include 'includes/header.php';
include 'db.php';
include 'md_parser.php';

$thread_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch thread details
$sql_thread = "SELECT * FROM threads WHERE id = ?";
$stmt_thread = $conn->prepare($sql_thread);
$stmt_thread->bind_param("i", $thread_id);
$stmt_thread->execute();
$result_thread = $stmt_thread->get_result();

if ($result_thread->num_rows > 0) {
    $thread = $result_thread->fetch_assoc();
    echo '<h2>' . htmlspecialchars($thread['title']) . '</h2>';
    echo '<p>Created by User ID: <a href="public_profile.php?id=' . htmlspecialchars($thread['user_id']) . '">' . sprintf('%04d', htmlspecialchars($thread['user_id'])) . '</a> on ' . htmlspecialchars($thread['created_at']) . '</p>';
} else {
    echo '<p>Thread not found.</p>';
    exit();
}

// Fetch posts for the current thread
$sql_posts = "
    SELECT posts.id, posts.content, 
           COALESCE(like_counts.like_count, 0) AS like_count,
           IF(user_likes.user_id IS NOT NULL, 1, 0) AS user_liked
    FROM posts
    LEFT JOIN (
        SELECT post_id, COUNT(*) AS like_count
        FROM likes
        GROUP BY post_id
    ) AS like_counts ON posts.id = like_counts.post_id
    LEFT JOIN likes AS user_likes ON posts.id = user_likes.post_id AND user_likes.user_id = ?
    WHERE posts.thread_id = ?
    ORDER BY posts.created_at DESC
";

$stmt_posts = $conn->prepare($sql_posts);
$stmt_posts->bind_param("ii", $user_id, $thread_id);
$stmt_posts->execute();
$result_posts = $stmt_posts->get_result();
$Parsedown = new Parsedown();
?>

<section>
    <h3>Posts</h3>
    <?php if ($result_posts->num_rows > 0): ?>
        <?php while ($row_post = $result_posts->fetch_assoc()): ?>
            <div class="post">
                <p><?php echo nl2br($Parsedown->text(htmlspecialchars($row_post['content']))); ?></p>
                <p>Likes: <?php echo htmlspecialchars($row_post['like_count']); ?></p>
                <p>Posted by User ID: <a href="public_profile.php?id=<?= htmlspecialchars($thread['user_id']) ?>"><?= sprintf('%04d', htmlspecialchars($thread['user_id'])) ?></a></p>

                <form method="POST" action="like_post.php">
                    <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($row_post['id']); ?>">
                    <button type="submit" name="action" value="<?php echo $row_post['user_liked'] > 0 ? 'unlike' : 'like'; ?>">
                        <?php echo $row_post['user_liked'] > 0 ? 'Unlike' : 'Like'; ?>
                    </button>
                </form>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No posts available in this thread.</p>
    <?php endif; ?>
    <?php if (isset($_SESSION['user_id'])): ?>
        <h3>Create a New Post</h3>
        <form action="create_post.php" method="post">
            <input type="hidden" name="thread_id" value="<?php echo htmlspecialchars($thread_id); ?>">
            <label for="content">Post Content:</label>
            <br>
            <textarea id="content" name="content" required></textarea>
            <br>
            <button type="submit">Post</button>
            
        </form>
        <?php include "includes/gif_search.php"?>
    <?php else: ?>
        <p><a href="login.php">Login</a> to create a new post.</p>
    <?php endif; ?>

</section>

<?php include 'includes/footer.php'; ?>