<?php

namespace RealtimeLogger\Server;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class MessageComponent implements MessageComponentInterface {
    
    /**
     * @var SqlObjectStorage
     */
    protected $clients;

    protected $messages = [];

    function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    /**
     * When a client connect's to the application
     * 
     * @param  ConnectionInterface $connection
     */
    public function onOpen(ConnectionInterface $connection)
    {
        $this->clients->attach($connection);

        foreach ($this->messages as $message) 
        {
            $connection->send($message);
        }
    }

    /**
     * When a client sends a message to the application
     * 
     * @param  ConnectionInterface $from
     * @param  string              $message
     */
    public function onMessage(ConnectionInterface $from, $message)
    {
        if ($message == 'DELETE') 
        {
            $this->messages = [];
        }
        else 
        {
            $this->messages[] = $message;

            $this->sendMessageToAll($message);
        }
    }

    /**
     * A client closes the connection to the application
     * 
     * @param  ConnectionInterface $connection
     */
    public function onClose(ConnectionInterface $connection)
    {
        $this->clients->detach($connection);
    }

    /**
     * An error occurs within the application
     * 
     * @param  ConnectionInterface $connection
     * @param  Exception           $exception
     */
    public function onError(ConnectionInterface $connection, \Exception $exception)
    {
        print 'An error has occured: ' . $exception->getMessage() . "\n";
    }

    public function sendMessageToAll($message)
    {
        foreach ($this->clients as $client) 
        {
            $client->send($message);
        }
    }
}