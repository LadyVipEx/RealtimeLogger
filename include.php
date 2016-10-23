<?php 

require __DIR__ . '/vendor/autoload.php';

function RL()
{
    return forward_static_call_array([
        'RealtimeLogger\Client\RL', 
        'logg'
    ], func_get_args());
}