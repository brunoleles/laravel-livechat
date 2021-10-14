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
use function json_encode;
use function value;

class ChatServer implements MessageComponentInterface {

	/**
	 * @var SplObjectStorage|ConnectionInterface[]
	 */
	private $conns;
	
	/**
	 * @var SplObjectStorage|ConnectionInterface[]
	 */
	
	
	private $rooms;

	/**
	 * @var ChatMessageFactory
	 */
	private $message_facotry;

	public function __construct() {
		$this->conns = new SplObjectStorage();
		$this->message_facotry = new ChatMessageFactory();
		// $this->rooms = new Map(); // not implemented
	}

	public function onOpen(ConnectionInterface $conn) {
		$this->conns->attach($conn);
		echo "New connection! ({$conn->resourceId})\n";

		$this->send_to($conn, new NotificationMessage('Welcome...'));
		$this->send_to($conn, new DefaultMessage('The quick brown fox jumps over the lazy dog'));

		//NOTE: testing message rendering
		$x = new DefaultMessage('The quick brown fox jumps over the lazy dog');
		$x->from_me = true;
		$this->send_to($conn, $x);


		$this->send_to_all_except($conn, new NotificationMessage(sprintf(
								'(%s) joined',
								$conn->resourceId
		)));


		$this->send_to_all_except($conn, $this->message_facotry->create_from_conns($this->conns));


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
		$this->conns->detach($conn);

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

		foreach ($this->conns as $client) {
			dump($client->resourceId);

			if ($except !== $client) {
				$this->send_to($client, $message);
			}
		}
		echo "all done\n";
	}

}
