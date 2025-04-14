<?php
// api/get_conversations.php
require_once 'config.php';

if (!isLoggedIn()) {
    jsonResponse(['error' => 'Unauthorized'], 401);
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

$userId = getCurrentUserId();

try {
    $db = getDb();
    
    // Get conversations
    $stmt = $db->prepare('
        SELECT c.id, c.name, c.is_group, 
               c.created_at AS created_at,
               (SELECT COUNT(*) FROM conversation_members WHERE conversation_id = c.id) AS member_count,
               (SELECT MAX(created_at) FROM messages WHERE conversation_id = c.id) AS last_activity
        FROM conversations c
        JOIN conversation_members cm ON c.id = cm.conversation_id
        WHERE cm.user_id = :user_id
        ORDER BY last_activity DESC, c.created_at DESC
    ');
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    $conversations = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Get members of the conversation
        $memberStmt = $db->prepare('
            SELECT u.id, u.username, u.public_key
            FROM users u
            JOIN conversation_members cm ON u.id = cm.user_id
            WHERE cm.conversation_id = :conversation_id
        ');
        $memberStmt->bindValue(':conversation_id', $row['id'], PDO::PARAM_INT);
        $memberStmt->execute();
        
        $members = [];
        while ($member = $memberStmt->fetch(PDO::FETCH_ASSOC)) {
            $members[] = $member;
        }
        
        $row['members'] = $members;
        $conversations[] = $row;
    }
    
    $db = null; // Close the database connection
    
    jsonResponse(['conversations' => $conversations]);
} catch (Exception $e) {
    jsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], 500);
}
?>