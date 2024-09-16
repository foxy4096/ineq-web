<?php include 'includes/header.php'; ?>
<?php include 'db.php'; ?>

<h2>Login</h2>
<form action="login_process.php" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Login</button>
</form>

<?php include 'includes/footer.php'; ?>
