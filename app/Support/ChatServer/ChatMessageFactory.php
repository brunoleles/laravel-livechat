<?php

namespace App\Support\ChatServer;

use App\Support\ChatServer\Messages\AbstractMessage;
use App\Support\ChatServer\Messages\ConnsMessage;
use App\Support\ChatServer\Messages\DefaultMessage;
use App\Support\ChatServer\Messages\NotificationMessage;
use Ratchet\RFC6455\Messaging\Message;
use Ratchet\ConnectionInterface;
use function collect;
use function data_get;
use function GuzzleHttp\json_decode;
use function value;

class ChatMessageFactory {

	public function creeate_from_json($message) {
		$message = value(function() use ($message) {
			if ($message instanceof AbstractMessage) {
				return $message;
			}
			if ($message instanceof Message) {
				return json_decode((string) $message);
			}
			if (is_string($message)) {
				return json_decode($message);
			}
		});

		$type = data_get($message, 'type', 'default');
		$timestamp = data_get($message, 'type', 'timestamp');

		$new_message = value(function() use ($message, $type) {
			switch ($type) {
				case AbstractMessage::TYPE_DEFAULT:
					return new DefaultMessage(data_get($message, 'message'));
				case AbstractMessage::TYPE_NOTIFICATION:
					return new NotificationMessage(data_get($message, 'message'));
			}
		});

		if (!empty($new_message)) {
			$new_message->timestamp = $timestamp;
		}

		return $new_message;
	}

	public function create_from_conns($conns) {
		return new ConnsMessage(
				collect($conns)->map(function(ConnectionInterface $conn) {
					return $conn->resourceId;
				})->implode(','),
				collect($conns)->map(function(ConnectionInterface $conn) {
					return $conn->resourceId;
				})->all()
		);
	}

}
