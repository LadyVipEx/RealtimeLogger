<?php

namespace RealtimeLogger\Client;

use WebSocket\Client;

class RealtimeLogger {

    protected $messages = [];

    protected $serverAddress = 'localhost';

    protected $serverPort = 8085;

    /**
     * Send messages to server
     * 
     * @param  mixed $messages
     * @return this
     */
    public function logg(array $values)
    {
        $values = (array) $values;

        return $this->setMessages(
            $this->toMessage($values)
        )->send();
    }

    public function toMessage(array $values)
    {
        foreach ($values as $value) 
        {
            $message = (new ValueDescriber)
                ->setValue($value)
                ->getDescribedValue();
                
            $messages[] = $message;
        }

        return isset($messages) ? $messages : []; 
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function setMessages(array $messages)
    {
        $this->messages = $messages;

        return $this;
    }

    public function setServerAddress($address)
    {
        $this->serverAddress = $address;

        return $this;
    }

    public function getServerAddress()
    {
        return $this->serverAddress;
    }

    public function setServerPort($port)
    {
        $this->serverPort = $port;

        return $this;
    }

    public function getServerPort()
    {
        return $this->serverPort;
    }

    /**
     * Send HTTP-POST Request
     * 
     * @param  array  $message
     * @return mixed
     */
    public function send()
    {
        $client = new Client('ws://' 
            . $this->getServerAddress() 
            . ':' 
            . $this->getServerPort()
        );

        $client->send(json_encode($this->getMessages()));
    }
}