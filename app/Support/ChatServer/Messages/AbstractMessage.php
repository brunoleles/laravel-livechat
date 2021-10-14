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

	/**
	 * 
	 */
	const TYPE_CONNS = 'conns';
	
	public function __toString() {
		return json_encode($this);
	}

}
