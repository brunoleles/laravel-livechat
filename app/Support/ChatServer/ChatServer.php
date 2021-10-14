<?php

namespace App\Support\ChatServer;

use App\Support\ChatServer\Messages\AbstractMessage;
use App\Support\ChatServer\Messages\ConnsMessage;
use App\Support\ChatServer\Messages\DefaultMessage;
use App\Support\ChatServer\Messages\NotificationMessage;
use App\Support\Metas\AccessToken;
use App\Support\Metas\ConnectionInfo;
use Ds\Map;
use Exception;
use GuzzleHttp\Psr7\Request;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\Message;
use Ratchet\WebSocket\MessageComponentInterface;
use SplObjectStorage;
use function data_get;
use function dump;
use function json_encode;
use function value;

class ChatServer implements MessageComponentInterface {

    /**
     * @var SplObjectStorage|ConnectionInterface[]
     */
    private $conns;

    /**
     * @var Map|ConnectionInfo[]
     */
    private $infos;

    /**
     * @var AccessToken
     */
    private $server_token;

    /**
     * @var ChatMessageFactory
     */
    private $message_facotry;

    public function __construct() {
        $this->conns = new SplObjectStorage();
        $this->infos = new Map();
        $this->message_facotry = new ChatMessageFactory();
        $this->server_token = new AccessToken(0, 'Server', null);
    }

    public function onOpen(ConnectionInterface $conn) {
        /* @var $request Request */
        $request = $conn->httpRequest;

        $query = [];
        parse_str($request->getUri()->getQuery(), $query);

        $access_payload = data_get($query, 'access_payload');
        $access_token = ChatServerUtils::parse_access_payload($access_payload);

        if (empty($access_token)) {
            dump('connection rejected, invalid or absent access token');
            $conn->close();
            return;
        }

        $conn_info = new ConnectionInfo(
                $conn,
                $access_token
        );

        $this->conns->attach($conn);
        $this->infos->put($conn, $conn_info);

        dump("New connection! ({$conn->resourceId})");

        $this->send_to($conn, new NotificationMessage("Welcome {$access_token->name}..."));

        $this->send_to($conn, new DefaultMessage('The quick brown fox jumps over the lazy dog', from: $this->server_token,));
        $this->send_to($conn, new DefaultMessage('The quick brown fox jumps over the lazy dog', from: $this->server_token,));
        $this->send_to($conn, new DefaultMessage('The quick brown fox jumps over the lazy dog', from: $this->server_token,));
        $this->send_to($conn, new DefaultMessage('The quick brown fox jumps over the lazy dog', from: $this->server_token,));

        //NOTE: testing message rendering
        $x = new DefaultMessage('The quick brown fox jumps over the lazy dog');
        $x->from_me = true;
        $this->send_to($conn, $x);

        $this->send_to_all_except($conn, new NotificationMessage(sprintf(
                                '(%s@%s) joined',
                                $conn_info->token->name,
                                $conn_info->token->id,
        )));

        //NOTE: we will send the updated connection list to everyone
        $updated_users_message = new ConnsMessage('Users');
        foreach ($this->infos as $info) {
            $updated_users_message->conns[] = [
                'id' => $info->token->id,
                'name' => $info->token->name,
                'rid' => $info->connection->resourceId,
            ];
        }
        $this->send_to_all($updated_users_message);
    }

    public function onMessage(ConnectionInterface $from, $message) {
        $from_info = $this->infos->get($from);
        $message = $this->message_facotry->creeate_from_json($message);

        if (empty($message)) {
            //TODO: add more info
            return;
        }

        $this->send_to_all_except($from, $message);
    }

    public function onClose(ConnectionInterface $conn) {

        $this->conns->detach($conn);
        $this->infos->remove($conn);

        $this->send_to_all_except($conn, new NotificationMessage(sprintf(
                                '(%s@%s) left',
                                $conn_info->token->name,
                                $conn_info->token->id,
        )));

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    public function send_to(ConnectionInterface $to, $message) {
        $normalized_message = value(function () use ($message) {
            if ($message instanceof AbstractMessage) {
                return (string) $message;
            }

            if ($message instanceof Message) {
                return (string) $message;
            }

            if (is_string($message)) {
                return $message;
            }

            return json_encode($message);
        });

        $to->send($normalized_message);
    }

    public function send_to_all($message) {
        foreach ($this->conns as $client) {
            $this->send_to($client, $message);
        }
    }

    public function send_to_all_except($except, $message) {
        foreach ($this->conns as $client) {
            if ($except !== $client) {
                $this->send_to($client, $message);
            }
        }
    }

}
