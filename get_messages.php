<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

// Ensure the conversation ID is set
if (!isset($_SESSION['conversation_id'])) {
    echo json_encode(['error' => 'Conversation ID is not set']);
    exit;
}

// Connect to the database
try {
    $pdo = new PDO("mysql:host=localhost;dbname=chat_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Get conversation ID from session
$conversationId = (int)$_SESSION['conversation_id'];


// Fetch messages for the conversation
$stmt = $pdo->prepare("
    SELECT u.username, m.message, m.created_at 
    FROM messages m
    JOIN users u ON m.sender_id = u.id
    WHERE m.conversation_id = :conversation_id
    ORDER BY m.created_at ASC
");
$stmt->execute([':conversation_id' => $conversationId]);

// Fetch all messages
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return messages as JSON
echo json_encode($messages);
?>
