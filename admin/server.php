<?php
// Ensure composer autoload is included
$autoloadPath = __DIR__ . '/../vendor/autoload.php'; // Adjust path as needed

if (file_exists($autoloadPath)) {
    require $autoloadPath;
    echo "Autoload file loaded successfully.\n"; // Confirmation message
} else {
    echo "Autoload file not found at $autoloadPath\n"; // Error message
    exit; // Stop execution if the autoload file is not found
}

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

// Chat class implementing the MessageComponentInterface
class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage; // Store connected clients
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1; // Count other clients
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n",
            $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg); // Send message to all other clients
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close(); // Close the connection on error
    }
}

// Set up the server
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat() // Instantiate the Chat class
        )
    ),
    8080 // Port to run the server on
);

echo "WebSocket server running on port 8080\n";
$server->run(); // Run the server
