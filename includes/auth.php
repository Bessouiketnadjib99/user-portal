<?php
/**
 * User Authentication Functions
 */

/**
 * Authenticates a user with email and password
 */
function authenticateUser($email, $password) {
    global $conn;
    
    // Sanitize email input
    $email = sanitizeInput($email);
    
    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, first_name, last_name, email, password, role FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // If user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify password against hash
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
    }
    
    // Authentication failed
    return false;
}

/**
 * Registers a new user
 */
function registerUser($userData) {
    global $conn;
    
    // Hash the password
    $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
    
    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, position, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", 
        $userData['first_name'],
        $userData['last_name'],
        $userData['email'],
        $hashedPassword,
        $userData['position'],
        $userData['role']
    );
    
    return $stmt->execute();
}
?>