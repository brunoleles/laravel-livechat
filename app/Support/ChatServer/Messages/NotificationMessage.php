<?php

namespace App\Support\ChatServer\Messages;

class NotificationMessage extends AbstractMessage {

	public $type = 'notification';
	public $message;

	public function __construct($message) {
		$this->message = $message;
	}

}
