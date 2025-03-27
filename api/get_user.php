<?php
require_once '../includes/config.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    die("User ID is required");
}

$id = sanitizeInput($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    http_response_code(404);
    die("User not found");
}

header('Content-Type: application/json');
echo json_encode($user);
?>