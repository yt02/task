<?php
session_start();
include 'db_config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="dashboard-container">
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php
                // Dashboard for logged-in users
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT username FROM users WHERE id = $user_id";
                $result = $conn->query($sql);
                $user = $result->fetch_assoc();
            ?>
            <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
            <div class="dashboard-links">
                <a href="profile.php" class="btn">Profile</a>
                <a href="logout.php" class="btn btn-secondary">Logout</a>
            </div>
        <?php else: ?>
            <!-- Landing page for unregistered users -->
            <h1>Welcome to Our App!</h1>
            <p>Please register or login to access your dashboard.</p>
            <div class="landing-links">
                <a href="register.php" class="btn">Register</a>
                <a href="login.php" class="btn btn-secondary">Login</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
