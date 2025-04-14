<?php
// api/create_conversation.php
require_once 'config.php';

if (!isLoggedIn()) {
    jsonResponse(['error' => 'Unauthorized'], 401);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

// Get JSON data
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    jsonResponse(['error' => 'Invalid request data'], 400);
}

// Validate input
$userIds = $data['user_ids'] ?? [];
$name = $data['name'] ?? null;
$isGroup = $data['is_group'] ?? false;

if (empty($userIds)) {
    jsonResponse(['error' => 'No users selected for conversation'], 400);
}

// Add current user to the conversation
$userId = getCurrentUserId();
if (!in_array($userId, $userIds)) {
    $userIds[] = $userId;
}

try {
    $db = getDb();
    
    // Start transaction
    $db->beginTransaction();
    
    // Create conversation
    $stmt = $db->prepare('
        INSERT INTO conversations (name, is_group)
        VALUES (:name, :is_group)
    ');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':is_group', $isGroup ? 1 : 0, PDO::PARAM_INT);
    $stmt->execute();
    
    $conversationId = $db->lastInsertId();
    
    // Add members to conversation
    foreach ($userIds as $memberId) {
        $stmt = $db->prepare('
            INSERT INTO conversation_members (conversation_id, user_id)
            VALUES (:conversation_id, :user_id)
        ');
        $stmt->bindValue(':conversation_id', $conversationId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $memberId, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    // Get conversation details
    $stmt = $db->prepare('
        SELECT c.id, c.name, c.is_group, 
               c.created_at AS created_at
        FROM conversations c
        WHERE c.id = :id
    ');
    $stmt->bindValue(':id', $conversationId, PDO::PARAM_INT);
    $stmt->execute();
    $conversation = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Get members of the conversation
    $memberStmt = $db->prepare('
        SELECT u.id, u.username, u.public_key
        FROM users u
        JOIN conversation_members cm ON u.id = cm.user_id
        WHERE cm.conversation_id = :conversation_id
    ');
    $memberStmt->bindValue(':conversation_id', $conversationId, PDO::PARAM_INT);
    $memberStmt->execute();
    
    $members = [];
    while ($member = $memberStmt->fetch(PDO::FETCH_ASSOC)) {
        $members[] = $member;
    }
    
    $conversation['members'] = $members;
    
    // Commit transaction
    $db->commit();
    
    $db = null; // Close the database connection
    
    jsonResponse(['success' => true, 'conversation' => $conversation]);
} catch (Exception $e) {
    // Rollback on error
    if (isset($db)) {
        $db->rollBack();
    }
    jsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], 500);
}
?>