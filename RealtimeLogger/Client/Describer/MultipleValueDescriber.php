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

        $this->getValueDescriber()->increaseNestingLevel();

        foreach ($values as $key => $value) 
        {
            $describedValues[] = $this->getValueDescriber()
                ->getValueDescriber($value)
                ->setKey($key)
                ->getDescribed();
        }

        $this->getValueDescriber()->decreaseNestingLevel();

        return $this->setValue($describedValues);
    }
}
