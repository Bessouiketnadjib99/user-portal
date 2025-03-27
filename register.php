<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

if (isAuthenticated()) {
    redirectBasedOnRole();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userData = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'position' => $_POST['position'],
        'role' => 'User' // Default role for new registrations
    ];
    
    if (registerUser($userData)) {
        $success = 'Registration successful! You can now login.';
    } else {
        $error = 'Registration failed. Please try again.';
    }
}
?>

<?php include 'includes/header.php'; ?>

<main class="login-container">
    <div class="login-card">
        <h2>Register</h2>
        
        <?php if ($error): ?>
            <div class="alert error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required minlength="6">
            </div>
            
            <div class="form-group">
                <label for="position">Position</label>
                <input type="text" id="position" name="position" required>
            </div>
            
            <button type="submit" class="btn-primary">Register</button>
        </form>
        
        <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>