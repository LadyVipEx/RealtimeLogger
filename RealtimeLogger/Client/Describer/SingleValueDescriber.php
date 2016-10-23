<?php 

namespace RealtimeLogger\Client\Describer;

use RealtimeLogger\Client\Describer\AbstractValueDescriber;

class SingleValueDescriber extends AbstractValueDescriber
{
    /**
     * Handle's and set the value
     * 
     * @param  mixed $value
     * @return $this
     */
    public function handleValue($value)
    {
        return $this->setValue($value);
    }
}
