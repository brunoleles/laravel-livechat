<?php

namespace App\Support\ChatServer\Messages;

class NotificationMessage extends AbstractMessage {

	public $type = AbstractMessage::TYPE_NOTIFICATION;
	public $message;

	public function __construct($message) {
		$this->message = $message;
	}

}
