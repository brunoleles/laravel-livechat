<?php

namespace App\Support\ChatServer\Messages;

class DefaultMessage extends AbstractMessage {

	public $type = 'default';
	public $message;

	public function __construct($message) {
		$this->message = $message;
	}

}