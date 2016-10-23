<?php 

namespace RealtimeLogger\Client\Describer;

use RealtimeLogger\Client\Describer\AbstractValueDescriber;
use RealtimeLogger\Client\ValueDescriber;

class MultipleValueDescriber extends AbstractValueDescriber
{
    /**
     * Handle's and set the value
     * 
     * @param  mixed $value
     * @return $this
     */
    public function handleValue($values)
    {
        $describedValues = [];

        foreach ($values as $key => $value) 
        {
            $describedValues[] = (new ValueDescriber)
                ->getValueDescriber($value)
                ->setKey($key)
                ->getDescribed();
        }

        return $this->setValue($describedValues);
    }
}
