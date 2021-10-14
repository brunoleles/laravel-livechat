<?php

namespace App\Support\ChatServer\Messages;

use App\Support\Metas\AccessToken;

class DefaultMessage extends AbstractMessage {

    public $type = AbstractMessage::TYPE_DEFAULT;
    public $message;

    public function __construct($message, ?AccessToken $from = null) {
        parent::__construct(from: $from);
        $this->message = $message;
    }

}
