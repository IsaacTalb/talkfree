<?php
// api/update_group_name.php
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
$conversationId = $data['conversation_id'] ?? null;
$name = $data['name'] ?? null;

if (!$conversationId) {
    jsonResponse(['error' => 'Missing conversation ID'], 400);
}

if (!$name || trim($name) === '') {
    jsonResponse(['error' => 'Group name cannot be empty'], 400);
}

$userId = getCurrentUserId();

try {
    $db = getDb();
    
    // Check if user is part of the conversation
    $stmt = $db->prepare('
        SELECT 1 FROM conversation_members 
        WHERE conversation_id = :conversation_id AND user_id = :user_id
    ');
    $stmt->bindValue(':conversation_id', $conversationId, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    if (!$stmt->fetch()) {
        jsonResponse(['error' => 'You are not a member of this conversation'], 403);
    }
    
    // Check if conversation is a group
    $stmt = $db->prepare('
        SELECT is_group FROM conversations 
        WHERE id = :conversation_id
    ');
    $stmt->bindValue(':conversation_id', $conversationId, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$row || !$row['is_group']) {
        jsonResponse(['error' => 'Cannot rename a non-group conversation'], 400);
    }
    
    // Update the group name
    $stmt = $db->prepare('
        UPDATE conversations 
        SET name = :name 
        WHERE id = :conversation_id
    ');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':conversation_id', $conversationId, PDO::PARAM_INT);
    $stmt->execute();
    
    $db = null; // Close the database connection
    
    jsonResponse(['success' => true, 'message' => 'Group name updated successfully']);
} catch (Exception $e) {
    jsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], 500);
}
?>