<?php 

require __DIR__ . '/vendor/autoload.php';

$server = new RealtimeLogger\Server\Server;

$server->setPort(8085)->run();