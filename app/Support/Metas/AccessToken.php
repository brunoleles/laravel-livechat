<?php

namespace App\Support\Metas;

final class AccessToken {

    public function __construct(
            public ?string $id,
            public ?string $name,
            public ?string $ip,
    ) {
        
    }

}
