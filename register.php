<?php include 'includes/header.php'; ?>
<?php include 'db.php'; ?>

<h2>Register</h2>
<form action="register_process.php" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required>
    <br>
    <button type="submit">Register</button>
</form>

<?php include 'includes/footer.php'; ?>
