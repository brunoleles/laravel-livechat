<?php

namespace App\Support\ChatServer;

use App\Support\ChatServer\Messages\AbstractMessage;
use App\Support\ChatServer\Messages\DefaultMessage;
use App\Support\ChatServer\Messages\NotificationMessage;
use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\MessageComponentInterface;
use SplObjectStorage;
use function json_encode;
use function value;

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


		$this->send_to($conn, new NotificationMessage('Welcome...'));
		$this->send_to($conn, new DefaultMessage('The quick brown fox jumps over the lazy dog'));

		$this->send_to_all_except($conn, new NotificationMessage(sprintf(
								'%s joined',
								$conn->resourceId
		)));
	}

	public function onMessage(ConnectionInterface $from, $message) {
		$numRecv = count($this->clients) - 1;

		echo sprintf(
				'Connection %d sending message "%s" to %d other connection%s' . "\n", $from->resourceId,
				$message,
				$numRecv,
				$numRecv == 1 ? '' : 's'
		);

		$this->send_to_all_except($from, $message);
	}

	public function onClose(ConnectionInterface $conn) {
		$this->clients->detach($conn);

		$this->send_to_all_except($conn, new NotificationMessage(sprintf(
								'%s left',
								$conn->resourceId
		)));

		echo "Connection {$conn->resourceId} has disconnected\n";
	}

	public function onError(ConnectionInterface $conn, Exception $e) {
		echo "An error has occurred: {$e->getMessage()}\n";

		$conn->close();
	}

	public function send_to(ConnectionInterface $conn, $message) {
		$norm_message = value(function() use ($message) {
			if ($message instanceof AbstractMessage) {
				return (string) $message;
			}

			if (is_string($message)) {
				return $message;
			}

			return json_encode($message);
		});
		$conn->send($norm_message);
	}

	public function send_to_all_except($except, $message) {
		foreach ($this->clients as $client) {
			if ($except !== $client) {
				$this->send_to($client, $message);
			}
		}
	}

}
