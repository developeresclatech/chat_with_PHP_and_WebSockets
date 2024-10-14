<?php
require __DIR__ . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $pdo;

    public function __construct() {
        $this->clients = new \SplObjectStorage;

        // Connect to the MySQL database
        $this->pdo = new \PDO("mysql:host=localhost;dbname=chat_db", "root", "");
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);
        $username = $data['username'];
        $message = $data['message'];

        $numRecv = count($this->clients) - 1;
        echo sprintf(
            'Connection %d sending message "%s" from "%s" to %d other connection%s' . "\n",
            $from->resourceId,
            $message,
            $username,
            $numRecv,
            $numRecv == 1 ? '' : 's'
        );

        // Save message to the database with conversation_id
        $this->saveMessage($username, $message, $data['conversation_id']);

        // Broadcast message to all connected clients
        foreach ($this->clients as $client) {
            $client->send(json_encode(['username' => $username, 'message' => $message]));
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    // Save message with conversation_id and user_id
    protected function saveMessage($username, $message, $conversationId) {
        // Get user_id based on username
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Insert the message into the database
        if ($user) {
            $stmt = $this->pdo->prepare("
                INSERT INTO messages (conversation_id, sender_id, message)
                VALUES (:conversation_id, :sender_id, :message)
            ");
            $stmt->execute([
                ':conversation_id' => $conversationId,
                ':sender_id' => $user['id'],
                ':message' => $message
            ]);
            echo "Message saved to the database.\n";
        }
    }
}

// Set up the WebSocket server
$chatServer = new Chat();
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            $chatServer
        )
    ),
    8080
);

echo "WebSocket server running on ws://localhost:8080...\n";
$server->run();
