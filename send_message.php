<?php
session_start();

require __DIR__ . '/vendor/autoload.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=chat_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}




if (!isset($_SESSION['user_id'])) {
    echo "Error: User is not logged in.";
    exit;
}

if (!isset($_SESSION['conversation_id'])) { 
    echo "Error: Conversation ID is not set.";
    exit;
}

$message = $_POST['message'];
$conversation_id = $_SESSION['conversation_id'];
$sender_id = $_SESSION['user_id'];

if (empty($message) || empty($conversation_id)) {
    echo "Error: Invalid input.";
    exit;
}

// var_dump($_SESSION);
// die();
// Check if the conversation exists
$stmt = $pdo->prepare("SELECT id FROM conversations WHERE id = :conversation_id LIMIT 1");
$stmt->execute([':conversation_id' => $conversation_id]);
$conversation = $stmt->fetch(PDO::FETCH_ASSOC);

if ($conversation) {
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

    // Fetch all messages from the messages table for the sender
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE sender_id = :sender_id");
    $stmt->execute([':sender_id' => $sender_id]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($messages) {
        // Display the messages
        foreach ($messages as $row) {
            // echo "Message ID: " . htmlspecialchars($row['id']) . "<br>";
            // echo "Conversation ID: " . htmlspecialchars($row['conversation_id']) . "<br>";
            // echo "Sender ID: " . htmlspecialchars($row['sender_id']) . "<br>";
            // echo htmlspecialchars($row['message']) . "<br>";
            // echo htmlspecialchars($row['created_at']) . "<br><br>"; // Adjust 'created_at' field as needed
        }
    } else {
        echo "No messages found for this sender.";
    }
} else {
    echo "Error: Conversation does not exist.";
}

?>
