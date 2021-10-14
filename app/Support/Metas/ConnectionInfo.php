<?php

namespace App\Support\Metas;

use Ratchet\ConnectionInterface;

final class ConnectionInfo {

    public function __construct(
            public ?ConnectionInterface $connection = null,
            public ?AccessToken $token = null,
    ) {
        
    }

}
