<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=chat_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User is not logged in']);
    exit;
}

$message = $_POST['message'] ?? '';
$sender_id = $_SESSION['user_id'];
$conversation_id = $_POST['conversation_id'] ?? null;

if (empty($message) || empty($conversation_id)) {
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

try {
    // Insert the message into the messages table
    $stmt = $pdo->prepare("INSERT INTO messages (conversation_id, sender_id, message) 
                            VALUES (:conversation_id, :sender_id, :message)");
    $stmt->execute([
        ':conversation_id' => $conversation_id,
        ':sender_id' => $sender_id,
        ':message' => $message
    ]);

    // Add the participant if not already present in conversation_participants
    $stmt = $pdo->prepare("INSERT IGNORE INTO conversation_participants (conversation_id, user_id) 
                            VALUES (:conversation_id, :user_id)");
    $stmt->execute([
        ':conversation_id' => $conversation_id,
        ':user_id' => $sender_id
    ]);

    echo json_encode(['success' => 'Message sent']);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error sending message: ' . $e->getMessage()]);
}
?>
