<?php
session_start();

require '../vendor/autoload.php';
// require __DIR__ . '/vendor/autoload.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=chat_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}



// var_dump($_POST);

// print_r($_POST);



// if (!isset($_SESSION['user_id'])) {
//     echo "Error: User is not logged in.";
//     exit;
// }




$message = $_POST['message'];
$sender_id = $_SESSION['user_id'];

// if (empty($message) || empty($conversation_id)) {
//     echo "Error: Invalid input.";
//     exit;
// }
$conversation_id = $_POST['conversation_id'];

// Debug output
// var_dump($resever_id); // Check if the value is correct

// // Prepare the SQL statement
// $stmt = $pdo->prepare("SELECT conversation_id FROM messages WHERE id = :conversation_id");

// // Bind the resever_id to the placeholder
// $stmt->bindParam(':conversation_id', $conversation_id, PDO::PARAM_INT);

// // Execute the statement
// $stmt->execute();

// // Fetch the result
// $result = $stmt->fetch(PDO::FETCH_ASSOC);

// // Check if a conversation_id was found
// if ($result) {
//     $conversation_id = $result['conversation_id'];
//     // "Conversation ID: " . $conversation_id;
// } else {
//     echo "No conversation found for the provided resever_id.";
// }



// var_dump($result);
// // print_r($_ POST);


// die();

// Prepare the SQL statement correctly
// $stmt = $pdo->prepare("SELECT conversation_id FROM conversation_participants WHERE $resever_id = :sender_id");

// $stmt = $pdo->prepare("SELECT id FROM conversations WHERE id = :conversation_id LIMIT 1");
// $stmt->execute([':conversation_id' => $conversation_id]);
// $conversation = $stmt->fetch(PDO::FETCH_ASSOC);

if ($conversation_id) {
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

    // // Fetch all messages from the messages table for the sender
    // $stmt = $pdo->prepare("SELECT * FROM messages WHERE sender_id = :sender_id");
    // $stmt->execute([':sender_id' => $sender_id]);
    // $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else {
    echo "Error: Conversation does not exist.";
}
?>