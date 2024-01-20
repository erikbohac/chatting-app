<?php

require __DIR__ . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $rooms;

    public function __construct() {
        $this->clients = new \SplObjectStorage();
        $this->rooms = [];
    }

    public function onOpen(ConnectionInterface $conn) {
        $query = $conn->httpRequest->getUri()->getQuery();
        $room = empty($query) ? 'default' : $query;

        if (!isset($this->rooms[$room])) {
            $this->rooms[$room] = new \SplObjectStorage();
        }

        $this->rooms[$room]->attach($conn);
        $this->clients->attach($conn);

        echo "New connection to room {$room}! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {

        $room = $from->httpRequest->getUri()->getQuery();

        foreach ($this->rooms[$room] as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);

        foreach ($this->rooms as $roomClients) {
            $roomClients->detach($conn);
        }

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8888
);

echo "WebSocket server started...\n";

$server->run();

?>