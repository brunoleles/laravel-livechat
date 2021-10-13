<?php

namespace App\Support\ChatServer\Messages;

use json_encode;

abstract class AbstractMessage {

	/**
	 * 
	 */
	const TYPE_DEFAULT = 'default';

	/**
	 * 
	 */
	const TYPE_NOTIFICATION = 'notification';

	public function __toString() {
		return json_encode($this);
	}

}
