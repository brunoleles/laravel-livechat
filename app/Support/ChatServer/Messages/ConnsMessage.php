<?php

namespace App\Support\ChatServer\Messages;

class ConnsMessage extends AbstractMessage {

	public $type = AbstractMessage::TYPE_CONNS;

	/**
	 * @var string
	 */
	public $message;

	/**
	 * @var array
	 */
	public $conns;

	public function __construct($message, $conns = []) {
		$this->message = $message;
		$this->conns = $conns;
	}

}
