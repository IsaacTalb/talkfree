<?php
// api/get_user_details.php
require_once 'config.php';

if (!isLoggedIn()) {
    jsonResponse(['error' => 'Unauthorized'], 401);
}

$userId = isset($_GET['id']) ? (int)$_GET['id'] : getCurrentUserId();

// Only allow getting details for the current user
if ($userId != getCurrentUserId()) {
    jsonResponse(['error' => 'Unauthorized'], 403);
}

try {
    $db = getDb();
    
    $stmt = $db->prepare('
        SELECT id, username, created_at FROM users 
        WHERE id = :id
    ');
    $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        jsonResponse(['error' => 'User not found'], 404);
    }
    
    $db = null; // Close the database connection
    
    jsonResponse(['user' => $user]);
} catch (Exception $e) {
    jsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], 500);
}
?>