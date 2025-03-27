<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

// Redirect if already logged in
if (isAuthenticated()) {
    redirectBasedOnRole();
}

$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password";
    } elseif (authenticateUser($email, $password)) {
        // Redirect to appropriate dashboard
        redirectBasedOnRole();
    } else {
        $error = "Invalid email or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Portal - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h2>Welcome Back</h2>
                <p>Please login to your account</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form class="auth-form" action="login.php" method="POST">
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>
            
            <div class="auth-footer">
                Don't have an account? <a href="register.php">Create one</a>
            </div>
        </div>
    </div>
</body>
</html>