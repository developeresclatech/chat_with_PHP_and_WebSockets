<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

if (!isset($_GET['conversation_id'])) {
    echo json_encode(['error' => 'Conversation ID is missing']);
    exit;
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=chat_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $conversationId = (int) $_GET['conversation_id'];

    // Fetch messages for the conversation
    $stmt = $pdo->prepare("
        SELECT u.username, m.message, m.created_at 
        FROM messages m
        JOIN users u ON m.sender_id = u.id
        WHERE m.conversation_id = :conversation_id
        ORDER BY m.created_at ASC
    ");
    $stmt->execute([':conversation_id' => $conversationId]);

    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($messages);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
