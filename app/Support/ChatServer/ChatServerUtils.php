<?php

namespace App\Support\ChatServer;

use App\Support\Metas\AccessToken;
use Illuminate\Support\Facades\Crypt;
use Webmozart\Assert\Assert;

abstract class ChatServerUtils {

    static public function parse_access_payload($value): ?AccessToken {
        try {
            $access_token = Crypt::decrypt($value);
            Assert::isInstanceOf($access_token, AccessToken::class);

            return $access_token;
        } catch (\Exception $ex) {
            
        }
        return null;
    }

}
