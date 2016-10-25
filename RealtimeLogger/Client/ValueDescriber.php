<?php

namespace RealtimeLogger\Client;

use RealtimeLogger\Client\Describer\MultipleValueDescriber;
use RealtimeLogger\Client\Describer\ObjectValueDescriber;
use RealtimeLogger\Client\Describer\SingleValueDescriber;

class ValueDescriber
{
    /**
     * @var integer
     */
    protected $nestingLevel = 1;

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
                    if ($this->getNestingLevel() > 11) 
                    {
                        return (new SingleValueDescriber)
                            ->setValueDescriber($this)
                            ->isExplainingString(true)
                            ->giveValue('...');
                    }

                    $valueDescriber = (new MultipleValueDescriber);
                break;

            case 'object':
                    if ($this->getNestingLevel() > 11) 
                    {
                        return (new SingleValueDescriber)
                            ->setValueDescriber($this)
                            ->isExplainingString(true)
                            ->giveValue('...');
                    }

                    $valueDescriber = (new ObjectValueDescriber);
                break;

            default:
                    $valueDescriber = (new SingleValueDescriber);
                break;
        }

        return $valueDescriber->setValueDescriber($this)
            ->giveValue($value);
    }

    /**
     * NestingLevel getter
     * 
     * @return integer
     */
    public function getNestingLevel()
    {
        return $this->nestingLevel;
    }

    /**
     * Increase NestingLevel
     * 
     * @return $this
     */
    public function increaseNestingLevel()
    {
        $this->nestingLevel++;

        return $this;
    }

    /**
     * Decrease NestingLevel
     * @return [type] [description]
     */
    public function decreaseNestingLevel()
    {
        $this->nestingLevel--;

        return $this;
    }

    /**
     * DescribedValue setter
     * 
     * @param array $describedValue
     */
    public function setDescribedValue($describedValue)
    {
        $this->describedValue = $describedValue;

        return $this; 
    }

    /**
     * DescribedValue getter
     * 
     * @return array
     */
    public function getDescribedValue()
    {
        return $this->describedValue;
    }
}