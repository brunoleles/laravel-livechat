<?php

namespace App\Support\ChatServer\Messages;

use App\Support\Metas\AccessToken;
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

    public $timestramp;
    public $from_id;
    public $from_name;

    public function __construct(public ?AccessToken $from = null) {
        if ($from) {
            $this->from_id = $from->id;
            $this->from_name = $from->name;
        }
    }

    public function __toString() {
        return json_encode($this);
    }

}
