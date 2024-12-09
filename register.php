<?php
include 'db_config.php';
include 'header.php';

$registrationSuccess = false; // Variable to check registration status
$error = ""; // Variable to store error messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Server-side validation
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = "All fields are required.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // Check if the username or email already exists
        $check_sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
        $result = $conn->query($check_sql);

        if ($result->num_rows > 0) {
            $error = "Username or Email already exists. Please choose a different one.";
        } else {
            // Hash password and insert into database
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
            if ($conn->query($sql) === TRUE) {
                $registrationSuccess = true; // Set success flag to true
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
}
?>


<div class="form-container">
    <h1>Register</h1>
    <?php if (!empty($error)) : ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post" id="registrationForm">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <p class="hint">* Password must be at least 8 characters long.</p>
        
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" name="confirmPassword" id="confirmPassword" required>
        <span id="matchIcon" class="password-icon"></span>
        
        <button type="submit" id="registerBtn">Register</button>
    </form>

     <!-- Add link to login page -->
     <p class="login-link">
        Already have an account? <a href="login.php">Login</a>
    </p>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');
    const matchIcon = document.getElementById('matchIcon');

    // Validate password match as the user types
    confirmPassword.addEventListener('input', () => {
        if (password.value.length >= 8 && confirmPassword.value === password.value) {
            matchIcon.textContent = '✔'; // Show tick icon
            matchIcon.style.color = 'green';
        } else if (password.value.length >= 8) {
            matchIcon.textContent = '✖'; // Show cross icon
            matchIcon.style.color = 'red';
        } else {
            matchIcon.textContent = ''; // Clear icon
        }
    });

    // Provide real-time feedback for password length
    password.addEventListener('input', () => {
        if (password.value.length >= 8) {
            password.style.borderColor = 'green';
        } else {
            password.style.borderColor = 'red';
        }
    });
});
</script>
