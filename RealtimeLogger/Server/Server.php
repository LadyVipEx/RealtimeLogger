<?php

namespace RealtimeLogger\Server;

use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;

use RealtimeLogger\Server\MessageComponent;

class Server
{
    protected $port = 8000;

    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function run()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new MessageComponent
                )
            ), $this->getPort()
        );

        $server->run();
    }
}
