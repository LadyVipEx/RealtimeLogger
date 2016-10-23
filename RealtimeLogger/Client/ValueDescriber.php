<?php

namespace RealtimeLogger\Client;

use RealtimeLogger\Client\Describer\MultipleValueDescriber;
use RealtimeLogger\Client\Describer\ObjectValueDescriber;
use RealtimeLogger\Client\Describer\SingleValueDescriber;

class ValueDescriber
{
    /**
     * @var array
     */
    protected $describedValue;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * Value setter
     * 
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;

        $this->setDescribedValue(
            $this->describeValue($value)
        );

        return $this;
    }
    
    /**
     * Value getter
     * 
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    public function describeValue($value)
    {
        return $this->getValueDescriber($value)
            ->getDescribed();
    }

    public function getValueDescriber($value)
    {
        switch (gettype($value)) 
        {
            case 'array':
                    return (new MultipleValueDescriber)
                        ->giveValue($value);
                break;
                
            case 'object':
                    return (new ObjectValueDescriber)
                        ->giveValue($value);
                break;
            
            default:
                    return (new SingleValueDescriber)
                        ->giveValue($value);
                break;
        }
    }

    public function setDescribedValue($describedValue)
    {
        $this->describedValue = $describedValue;

        return $this; 
    }

    public function getDescribedValue()
    {
        return $this->describedValue;
    }
}