<?php 

namespace RealtimeLogger\Client\Describer;

abstract class AbstractValueDescriber
{
    protected $originalValue;

    protected $explainingString;

    protected $key = false;

    protected $prefix = '';

    protected $value;

    protected $type;

    /**
     * Give value for description
     * 
     * @param  mixed $value
     * @return 
     */
    public function giveValue($value)
    {
        return $this->setOriginalValue($value)
            ->handleValue($value);
    }

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

    public function setOriginalValue($value)
    {
        $this->originalValue = $value;

        return $this;
    }

    public function getOriginalValue()
    {
        return $this->originalValue;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function getType()
    {
        return gettype($this->getOriginalValue());
    }

    public function isExplainingString($boolean = null)
    {
        if (is_null($boolean)) 
        {
            return $this->explainingString;
        }

        $this->explainingString = $boolean;

        return $this;
    }

    public function getDescribed()
    {
        return [
            'type'              => $this->getType(),
            'key'               => $this->getKey(),
            'explaining_string' => $this->isExplainingString(),
            'prefix'            => $this->getPrefix(),
            'value'             => $this->getValue()
        ];
    }
}