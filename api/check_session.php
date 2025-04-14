<?php
// api/check_session.php
require_once 'config.php';

if (!isLoggedIn()) {
    jsonResponse(['error' => 'Unauthorized'], 401);
} else {
    try {
    // Get user data
    $db = getDb();
    $stmt = $db->prepare('SELECT id, username, public_key FROM users WHERE id = :id');
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        // Invalid user in session
        session_destroy();
        jsonResponse(['error' => 'Invalid user session'], 401);
    }
    
    jsonResponse([
        'loggedIn' => true,
        'user' => [
            'id' => $user['id'],
            'username' => $user['username']
        ]
    ]);
    } catch (Exception $e) {
        jsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    } finally {
        $db = null; // Close the database connection
    }
}
?>