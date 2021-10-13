<?php

namespace App\Support\ChatServer\Messages;

use json_encode;

abstract class AbstractMessage {

	public function __toString() {
		return json_encode($this);
	}

}
