<?php

namespace RealtimeLogger\Client;

use RealtimeLogger\Client\RealtimeLogger;

class RL {
    
    /**
     * A quick static route for the Realtime logger
     * 
     * @param  mixed $message
     * @return void
     */
    public static function logg(...$message)
    {
        return (new RealtimeLogger)
            ->logg($message);
    }
}