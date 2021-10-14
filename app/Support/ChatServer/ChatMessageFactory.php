<?php

namespace App\Support\ChatServer;

use App\Support\ChatServer\Messages\AbstractMessage;
use App\Support\ChatServer\Messages\ConnsMessage;
use App\Support\ChatServer\Messages\DefaultMessage;
use App\Support\ChatServer\Messages\NotificationMessage;
use App\Support\Metas\AccessToken;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\Message;
use function collect;
use function data_get;
use function GuzzleHttp\json_decode;
use function value;

class ChatMessageFactory {

    public function creeate_from_json($message) {
        $message = value(function () use ($message) {
            if ($message instanceof AbstractMessage) {
                return $message;
            }
            if ($message instanceof Message) {
                return json_decode((string) $message);
            }
            if (is_string($message)) {
                return json_decode($message);
            }
        });

        $type = data_get($message, 'type', 'default');
        $timestamp = data_get($message, 'type', 'timestamp');
        $access_token = ChatServerUtils::parse_access_payload(data_get($message, 'access_payload'));

        if (!$access_token instanceof AccessToken) {
            return null;
        }

        /* @var $new_message AbstractMessage */
        $new_message = value(function () use ($message, $type) {
            switch ($type) {
                case AbstractMessage::TYPE_DEFAULT:
                    return new DefaultMessage(data_get($message, 'message'));
                case AbstractMessage::TYPE_NOTIFICATION:
                    return new NotificationMessage(data_get($message, 'message'));
            }
        });

        if (!empty($new_message)) {
            $new_message->timestamp = $timestamp;
            $new_message->from_id = $access_token->id;
            $new_message->from_name = $access_token->name;
        }

        return $new_message;
    }

    

}
