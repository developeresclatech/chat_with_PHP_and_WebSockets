<?php
require 'vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use PDO;
use PDOException;

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage; // Storage of all active connections
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection
        $this->clients->attach($conn);
        echo "New connection: {$conn->resourceId}\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);

        // Validate message structure
        if (!isset($data['conversation_id'], $data['sender_id'], $data['message'], $data['username'])) {
            return; // Invalid message format
        }

        // Prepare message to broadcast
        $messageData = json_encode([
            'username' => $data['username'],
            'message' => $data['message'],
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Send the message to all connected clients
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($messageData);
            }
        }

        // Save the message to the database
        if (!$this->saveMessage($data['conversation_id'], $data['sender_id'], $data['message'])) {
            echo "Failed to save message to database.\n";
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // Detach the connection
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    protected function saveMessage($conversation_id, $sender_id, $message) {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=chat_db", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("INSERT INTO messages (conversation_id, sender_id, message) VALUES (:conversation_id, :sender_id, :message)");
            return $stmt->execute([
                ':conversation_id' => $conversation_id,
                ':sender_id' => $sender_id,
                ':message' => $message,
            ]);
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage() . "\n";
            return false; // Return false on failure
        }
    }
}

// Run the server
$server = IoServer::factory(new HttpServer(new WsServer(new Chat())), 8080);
$server->run();
