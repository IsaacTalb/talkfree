<?php
// api/delete_conversation.php
require_once 'config.php';

if (!isLoggedIn()) {
    jsonResponse(['error' => 'Unauthorized'], 401);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

// Get conversation ID
$data = json_decode(file_get_contents('php://input'), true);
$conversationId = $data['conversation_id'] ?? null;

if (!$conversationId) {
    jsonResponse(['error' => 'Missing conversation ID'], 400);
}

$userId = getCurrentUserId();

try {
    $db = getDb();
    
    // Start transaction
    $db->beginTransaction();
    
    // Check if user is part of the conversation
    $stmt = $db->prepare('
        SELECT 1 FROM conversation_members 
        WHERE conversation_id = :conversation_id AND user_id = :user_id
    ');
    $stmt->bindValue(':conversation_id', $conversationId, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    if (!$stmt->fetch()) {
        $db->rollBack();
        jsonResponse(['error' => 'You are not a member of this conversation'], 403);
    }
    
    // Delete all messages
    $stmt = $db->prepare('
        DELETE FROM messages 
        WHERE conversation_id = :conversation_id
    ');
    $stmt->bindValue(':conversation_id', $conversationId, PDO::PARAM_INT);
    $stmt->execute();
    
    // Delete all members
    $stmt = $db->prepare('
        DELETE FROM conversation_members 
        WHERE conversation_id = :conversation_id
    ');
    $stmt->bindValue(':conversation_id', $conversationId, PDO::PARAM_INT);
    $stmt->execute();
    
    // Delete the conversation
    $stmt = $db->prepare('
        DELETE FROM conversations 
        WHERE id = :conversation_id
    ');
    $stmt->bindValue(':conversation_id', $conversationId, PDO::PARAM_INT);
    $stmt->execute();
    
    // Commit transaction
    $db->commit();
    
    jsonResponse(['success' => true]);
} catch (Exception $e) {
    // Rollback on error
    if (isset($db)) {
        $db->rollBack();
    }
    jsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], 500);
}
?>