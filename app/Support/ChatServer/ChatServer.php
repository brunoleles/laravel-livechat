<?php

namespace App\Support\ChatServer;

use App\Support\ChatServer\Messages\AbstractMessage;
use App\Support\ChatServer\Messages\DefaultMessage;
use App\Support\ChatServer\Messages\NotificationMessage;
use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\Message;
use Ratchet\WebSocket\MessageComponentInterface;
use SplObjectStorage;
use function dump;
use function GuzzleHttp\json_decode;
use function json_encode;
use function value;

class ChatServer implements MessageComponentInterface {

	protected $clients;
	protected $rooms;

	/**
	 * @var ChatMessageFactory
	 */
	protected $message_facotry;

	public function __construct() {
		$this->clients = new SplObjectStorage();
		$this->message_facotry = new ChatMessageFactory();
		// $this->rooms = new Map(); // not implemented
	}

	public function onOpen(ConnectionInterface $conn) {
		$this->clients->attach($conn);
		echo "New connection! ({$conn->resourceId})\n";
//		dump($conn);


		$this->send_to($conn, new NotificationMessage('Welcome...'));
		$this->send_to($conn, new DefaultMessage('The quick brown fox jumps over the lazy dog'));

		$this->send_to_all_except($conn, new NotificationMessage(sprintf(
								'(%s) joined',
								$conn->resourceId
		)));

		echo "   done.\n";
	}

	public function onMessage(ConnectionInterface $from, $message) {
//		$numRecv = count($this->clients) - 1;
//
//		echo sprintf(
//				'Connection %d sending message "%s" to %d other connection%s' . "\n", $from->resourceId,
//				$message,
//				$numRecv,
//				$numRecv == 1 ? '' : 's'
//		);

		$message = $this->message_facotry->creeate_from_json($message);
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
		echo "sendto\n";

		$norm_message = value(function() use ($message) {
			if ($message instanceof AbstractMessage) {
				return (string) $message;
			}

			if ($message instanceof Message) {
				return (string) $message;
			}

			if (is_string($message)) {
				return $message;
			}

			return json_encode($message);
		});

		echo "  " . $message;

		$conn->send($norm_message);

		echo "sendto done\n";
	}

	public function send_to_all_except($except, $message) {
		echo "all\n";

		foreach ($this->clients as $client) {
			dump($client->resourceId);

			if ($except !== $client) {
				$this->send_to($client, $message);
			}
		}
		echo "all done\n";
	}

	

}
