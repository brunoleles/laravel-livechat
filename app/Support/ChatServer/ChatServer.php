<?php

namespace App\Support\ChatServer;

use Ds\Map;
use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\MessageComponentInterface;
use SplObjectStorage;
use function dump;

class ChatServer implements MessageComponentInterface {

	protected $clients;
	protected $rooms;

	public function __construct() {
		$this->clients = new SplObjectStorage();
		// $this->rooms = new Map(); // not implemented
	}

	public function onOpen(ConnectionInterface $conn) {
		$this->clients->attach($conn);
		echo "New connection! ({$conn->resourceId})\n";
//		dump($conn);
	}

	public function onMessage(ConnectionInterface $from, $msg) {
		$numRecv = count($this->clients) - 1;

		echo sprintf(
				'Connection %d sending message "%s" to %d other connection%s' . "\n", $from->resourceId,
				$msg,
				$numRecv,
				$numRecv == 1 ? '' : 's'
		);

		dump( $msg );
		
		foreach ($this->clients as $client) {
			if ($from !== $client) {
				// The sender is not the receiver, send to each client connected
				$client->send($msg);
			}
		}
	}

	public function onClose(ConnectionInterface $conn) {
		$this->clients->detach($conn);

		echo "Connection {$conn->resourceId} has disconnected\n";
	}

	public function onError(ConnectionInterface $conn, Exception $e) {
		echo "An error has occurred: {$e->getMessage()}\n";

		$conn->close();
	}

}
