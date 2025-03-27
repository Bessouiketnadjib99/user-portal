<?php
// Strict error reporting
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// Secure session configuration
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_secure', '1');
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_samesite', 'Lax');
session_start();

// Prevent session fixation
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id();
    $_SESSION['initiated'] = true;
}

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'user_portal');
define('DB_CHARSET', 'utf8mb4');

// Establish database connection
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        throw new RuntimeException("Database connection failed: " . $conn->connect_error);
    }
    
    $conn->set_charset(DB_CHARSET);
} catch (Exception $e) {
    error_log($e->getMessage());
    die("System temporarily unavailable. Please try again later.");
}

// Security headers
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");

/**
 * Sanitizes input data
 * @param mixed $data Input to sanitize
 * @return string|array Sanitized output
 */
function sanitizeInput($data) {
    global $conn;
    
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = $conn->real_escape_string($data);
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/**
 * Checks if user is authenticated
 */
function isAuthenticated(): bool {
    return isset($_SESSION['user_id'], $_SESSION['role'], $_SESSION['last_activity']) && 
           time() - $_SESSION['last_activity'] < 3600; // 1 hour timeout
}

/**
 * Gets user role
 */
function getUserRole(): ?string {
    return $_SESSION['role'] ?? null;
}

/**
 * Redirects unauthenticated users
 */
function redirectIfNotAuthenticated(): void {
    if (!isAuthenticated()) {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header('Location: login.php');
        exit();
    }
}

/**
 * Redirects based on user role
 */
function redirectBasedOnRole(): void {
    if (isAuthenticated()) {
        $role = getUserRole();
        $routes = [
            'System Admin' => 'admin/dashboard.php',
            'HR' => 'hr/dashboard.php', 
            'User' => 'user/dashboard.php'
        ];
        
        if (isset($routes[$role])) {
            header("Location: {$routes[$role]}");
            exit();
        }
    }
}

// Update last activity time
$_SESSION['last_activity'] = time();
?>