<?php
// api/get_sessions.php
require_once 'config.php';

if (!isLoggedIn()) {
    jsonResponse(['error' => 'Unauthorized'], 401);
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

$userId = getCurrentUserId();
$currentSessionToken = getCurrentSessionToken();

try {
    $db = getDb();
    
    // Get all active sessions for the user
    $stmt = $db->prepare('
        SELECT id, user_agent, ip_address, 
               created_at, last_activity,
               (session_token = :current_token) as is_current
        FROM sessions 
        WHERE user_id = :user_id
        ORDER BY is_current DESC, last_activity DESC
    ');
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':current_token', $currentSessionToken, PDO::PARAM_STR);
    $stmt->execute();
    
    $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Convert `is_current` to boolean
    foreach ($sessions as &$session) {
        $session['is_current'] = (bool) $session['is_current'];
    }
    
    $db = null; // Close the database connection
    
    jsonResponse(['success' => true, 'sessions' => $sessions]);
} catch (Exception $e) {
    jsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], 500);
}
?>